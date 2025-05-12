<?php



/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/
use Illuminate\Support\Facades\Route;

Route::get('/', 'Front\AppointmentController@home')->name('welcome');

// Route::get('/home', function() {
//     return view('theme.home');
// })->name('theme');

Route::get('/test-otp', function () {
    $sessionData = Session()->all();
    // Print session data
    dd($sessionData);
});


/* all module route */

Route::middleware(['auth', 'xss'])->group(function () {

    //Route::resource('users','UserController');
    Route::resource('users','UserController')->except(['update']);
    Route::patch('users/{user}', 'UserController@update')->name('users.update')->middleware(['throttle:5,1', 'recaptcha', 'sql_guard']);    

    Route::resource('categories','CategoryController');

    Route::resource('customers','CustomerController');

    Route::resource('employees','EmployeeController');

    Route::resource('services','ServiceController');

    Route::resource('working-hours','WorkingHourController');

    Route::resource('appointments','AppointmentController');

});



/* settings route */

Route::middleware(['xss', 'auth'])->group(function () {

    Route::get('setting','SettingController@index')->name('setting');

    Route::post('setting/update/{id}','SettingController@update')->name('setting.update');

    Route::get('setting/payment','SettingController@payment')->name('setting.payment');

    Route::get('site/setting','SettingController@site')->name('setting.site');

    Route::post('site/setting/update/{id}','SettingController@siteUpdate')->name('setting.siteUpdate');

    Route::any('employee/complete/register','EmployeeController@completeRegister')->name('completeRegister');

    Route::post('contact/admin','Front\ServiceController@contact')->name('contact.email');

    Route::get('setting/notification', 'SettingController@notificationSetting')->name('notificationSetting');

    Route::post('sms-notification/config/update','SettingController@smsConfigUpdate')->name('sms.notification.update');
});



/* payment route */

Route::middleware(['auth', 'xss'])->group(function () {

    Route::get('payment/list','PaymentController@index')->name('paymentlist');

    Route::get('payment/view/{id}','PaymentController@show')->name('paymentview');

    Route::any('pay/{id}','PaymentController@pay')->name('pay');

    Route::get('employee/payment/list','PaymentController@employeepayment')->name('employee-paymentlist');

    Route::get('services/{id}/employee','ServiceController@employee')->name('service.employee');

    Route::get('employee/{id}/appointment','EmployeeController@appointment')->name('employees.appointment');

    Route::post('appointments/emp','AppointmentController@emp')->name('emp');

    Route::post('appointment/payment/maximum-time-expire','Front\AppointmentController@paymentTimeExpire')->name('maximum.time.expire');

});





/* status route */

Route::middleware(['auth', 'xss'])->group(function () {

    Route::post('/employee/status','EmployeeController@status')->name('status');

    Route::post('employees/categoryservice','EmployeeController@categoryservice')->name('categoryservice');

    //Route::patch('users/updatePassword/{id}','UserController@updatePassword')->name('updatePassword');
    Route::patch('users/updatePassword/{id}','UserController@updatePassword')->middleware(['throttle:5,1', 'recaptcha', 'sql_guard'])->name('updatePassword');

    Route::patch('users/social-profile/{id}','UserController@updateSocialProfile')->name('users.social');

    Route::delete('/remove/google/calendar/{id}', 'GoogleCalendarController@removegoogle')->name('removegoogle');
});

/* customer login route */

Route::prefix('customer')->middleware(['auth','xss'])->group(function () {

    Route::get('/appointment/{id}','AppointmentController@customerview')->middleware('auth')->name('customer-appointment');

    Route::post('/appointments','AppointmentController@customerAppointment')->middleware('auth')->name('customer.appointments');

    Route::get('/profile/{id}','UserController@profile')->middleware('auth')->name('customer-profile');

    Route::match(['get','post'],'/{id}/appointment','CustomerController@appointment')->middleware('auth')->name('customers.appointment');

    Route::get('/notification/{id?}','NotificationController@index')->middleware('auth')->name('notification');

    Route::any('/mark/notification','NotificationController@markNotification')->middleware('auth')->name('customer-notification');

});



Route::middleware(['auth', 'xss'])->group(function () {

    /* filter route */ 

    Route::any('payment/filter','PaymentController@filter')->name('payment-filter');

    /*notification route */

    Route::get('admin/notification/{id?}','NotificationController@notification')->name('admin-notification');
    Route::get('/send/email/calendar/{id}', 'GoogleCalendarController@SendEmailGoogleCalenderLink')->name('SendEmailGoogleCalenderLink');
});





/* front side route */

Route::prefix('appointment')->middleware('xss')->group(function () {

    Route::post('/approval/{id}','AppointmentController@approval')->name('approval');

    Route::post('/cancel/{id}','AppointmentController@cancel')->name('cancel');

    Route::post('/complete/{id}','AppointmentController@complete')->name('complete');

    Route::any('/filter','AppointmentController@filter')->name('appointment-filter');

    Route::post('/create','Front\AppointmentController@create')->name('appointment.create')->middleware(['throttle:3,1', 'recaptcha', 'sql_guard']);

    Route::get('/book','Front\AppointmentController@index')->name('appointment.book');

    Route::get('/thank-you','Front\PaymentController@index')->name('success');

    Route::get('/reminder/mail','Front\AppointmentController@remider')->name('remider');

});



Route::prefix('get')->middleware('xss')->group(function () {

    Route::get('/appointment','Front\AppointmentController@appointment')->name('getAppointment');

    Route::post('/service','Front\ServiceController@categories')->name('service');

    Route::post('/services','Front\ServiceController@services')->name('getService');

    Route::post('/employees','Front\ServiceController@employees')->name('getEmployee');

    Route::post('/another/employees','Front\ServiceController@anotherEmployee')->name('getAnotheremployee');

    Route::post('/intent','Front\PaymentController@intent')->name('intent');

});



Route::prefix('proceeds')->middleware('xss')->group(function () {

    Route::post('/paypal','Front\PaymentController@proceed')->name('proceed');

    Route::post('/razorpay/success','Front\PaymentController@razorpay')->name('razorpay');

});



Route::any('/timeslots','Front\ServiceController@getTimeSlot')->name('getTimeSlot');

Route::any('/slots','Front\ServiceController@getSlots')->name('getSlot');

Route::get('dashboard', 'AppointmentController@dashboard')->name('dashboard')->middleware(['auth','xss']);





// Route::post('register','Auth\RegisterController@store')->name('register')->middleware('xss');
// Route::post('/login','Auth\LoginController@login')->name('login')->middleware('xss');

Route::post('register', 'Auth\RegisterController@store')->name('register')->middleware(['xss', 'recaptcha', 'throttle:5,1', 'sql_guard']);
Route::post('/login', 'Auth\LoginController@login')->name('login')->middleware(['xss', 'recaptcha', 'throttle:5,1', 'sql_guard']);

Route::get('/signup','Auth\RegisterController@signup')->name('signup')->middleware('xss');

Route::post('/logout','Auth\LoginController@logout')->name('logout')->middleware(['auth','xss']);

Route::get('/{id}/appointment/payment/success','Front\PaymentController@stripeSuccess')->middleware('xss');

Route::post('payment','Front\PaymentController@afterPayment')->name('payment')->middleware('xss');

Route::post('/forgot/password/mail', 'Auth\ForgotPasswordController@forgotPasswordMail')->name('password.forgot.mail')->middleware(['xss', 'recaptcha', 'throttle:3,1', 'sql_guard']);

Route::post('/reset/password/form', 'Auth\ResetPasswordController@UserResetPassword')->name('password.reset.form');

Route::post('users/email/check','Front\ServiceController@checkEmailExist')->name('check.user.email')->middleware('xss');

Route::any('change/langauge/{lang}', 'SettingController@changeLangauge')->name('chang.locale')->middleware('xss');

Route::post('verify/mail', 'SettingController@verifySmtp')->name('verifyMail')->middleware('xss');

Route::post('verify/sms', 'NotificationController@verifySms')->name('verifySms')->middleware('xss');
/* abort 404 */

Route::any('/page/unauthorized',function() {

   abort(404);
})->name('unauthorized')->middleware('xss');

Route::get('/calendar', 'GoogleCalendarController@googleCalendarEventSync')->name('GoogleCalendarEventSync');

Route::get('/states','Front\ServiceController@getStates')->name('get-state');

Route::post('/payumoney/hash-generate','Front\PaymentController@generatePayuHash')->name('payumoney.hash-generate');
Route::post('/payumoney/success','Front\PaymentController@payumoney_success')->name('payumoney.success');
Route::post('/payumoney/fail','Front\PaymentController@payumoney_failure')->name('payumoney.fail');
Route::any('/payumoney/webhook','Front\PaymentController@payumoney_webhook')->name('payumoney.webhook');