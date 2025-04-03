<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('smtp_email',100)->nullable();
            $table->text('smtp_password')->nullable();
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->tinyInteger('smtp_mail')->default(0);
            $table->string('stripe_key')->nullable();
            $table->string('stripe_secret')->nullable();
            $table->string('stripe_live_key')->nullable();
            $table->string('stripe_secret_live')->nullable();
            $table->tinyInteger('is_stripe')->default(0);
            $table->string('stripe_active_mode')->default(0);
            $table->tinyInteger('is_paypal')->default(0);
            $table->string('paypal_active_mode')->default(0);
            $table->text('paypal_client_id')->nullable();
            $table->text('paypal_client_secret')->nullable();
            $table->string('paypal_locale')->default('en_US');
            $table->string('paypal_live_client_id')->nullable();
            $table->string('paypal_client_secret_live')->nullable();
            $table->string('currency')->default('inr');
            $table->string('currency_icon')->nullable();
            $table->string('custom_field_text')->default('employee');
            $table->string('custom_field_category')->default('category');
            $table->string('custom_field_service')->default('service');
            $table->tinyInteger('custom_time_slot')->default(0);
            $table->tinyInteger('is_razorpay')->default(0);
            $table->string('razorpay_active_mode')->default(0);
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d')->nullable();
            $table->tinyInteger('categories')->default(0);
            $table->tinyInteger('is_payment_later')->default(1);
            $table->string('razorpay_test_key')->nullable();
            $table->string('razorpay_test_secret')->nullable();
            $table->string('razorpay_live_key')->nullable();
            $table->string('razorpay_live_secret')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            'smtp_email' => 'john@example.com',
            'smtp_password' => encrypt('12345678'),
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_mail' => 0,
            'stripe_key'=> '',
            'stripe_secret'=> '',
            'stripe_live_key' => '',
            'stripe_secret_live' => '',
            'is_stripe' => 0,
            'is_paypal' => 0,
            'is_razorpay' => 0,
            'paypal_client_id'=> '',
            'paypal_client_secret'=>'',
            'paypal_live_client_id'=>'',
            'paypal_client_secret_live'=>'',
            'currency'=>'USD',
            'currency_icon'=> '$',
            'razorpay_test_key'=> '',
            'razorpay_test_secret'=> '',
            'razorpay_live_key'=> '',
            'razorpay_live_secret'=> '',
            'stripe_active_mode'=> 0,
            'paypal_active_mode'=> 0,
            'razorpay_active_mode'=> 0, 
            'timezone'=> 'UTC',
            'is_payment_later'=> 1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::dropIfExists('settings');
    }
}
