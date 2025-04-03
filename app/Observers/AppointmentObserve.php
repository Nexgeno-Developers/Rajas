<?php

namespace App\Observers;

use App\Entities\User;
use App\Helper\Helper;
use App\Entities\Setting;
use App\Entities\Appointment;
use App\Entities\employeeSettings;
use App\Helper\GoogleCal;

class AppointmentObserve
{
    /**
     * Handle the Appointment "created" event.
     *
     * @param  \App\Appointment  $appointment
     * @return void
     */
    public function created(Appointment $appointment)
    {
        $smtp = Setting::find(1);
        $timezone = $smtp->timezone;
        if($smtp->notification == 1) {
            $employee = User::find($appointment->employee_id);
            $customer = User::find($appointment->user_id);
            $admin = User::find($appointment->admin_id);
            $appDate = date('F j, Y', strtotime($appointment->date));
            $startTime = date('h:i A', strtotime($appointment->start_time));
            $endTime = date('h:i A', strtotime($appointment->finish_time));
            $notificationArr = array("to"=>"","body"=>"");
            if($appointment->status == "approved") {
                $customerSmsMsg = trans_choice('customer_apppointment_confirm_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
                $employeeSmsMsg = trans_choice('employee_appointment_confirm_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
                $adminSmsMsg = trans_choice('admin_appointment_confirm_notification', null, [
                    "admin" => $admin->first_name." ".$admin->last_name,
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]); 
            } else {
                $customerSmsMsg = trans_choice('customer_appointment_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $employeeSmsMsg = trans_choice('employee_appointment_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $adminSmsMsg = trans_choice('admin_appointment_notification', null, [
                    "admin" => $admin->first_name." ".$admin->last_name,
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
            }
            if($smtp->twilio_notify_customer) {
                $notificationArr = array(
                    'to' => trim($customer->phone),
                    'body' => trim($customerSmsMsg)
                );
                Helper::notification($notificationArr);
            }

            if($smtp->twilio_notify_employee) {
                $notificationArr = array(
                    'to' => trim($employee->phone),
                    'body' => trim($employeeSmsMsg)
                );
                Helper::notification($notificationArr);
            }

            if($smtp->twilio_notify_admin) {
                $notificationArr = array(
                    'to' => trim($admin->phone),
                    'body' => trim($adminSmsMsg)
                );
                Helper::notification($notificationArr);
            }
        }
    }

    /**
     * Handle the Appointment "updated" event.
     *
     * @param  \App\Appointment  $appointment
     * @return void
     */
    public function updated(Appointment $appointment)
    {
        $smtp = Setting::find(1);
        if($smtp->notification == 1) {
            $employee = User::find($appointment->employee_id);
            $customer = User::find($appointment->user_id);
            $admin = User::find($appointment->admin_id);
            $appDate = date('F j, Y', strtotime($appointment->date));
            $startTime = date('h:i A', strtotime($appointment->start_time));
            $endTime = date('h:i A', strtotime($appointment->finish_time));
            $notificationArr = array("to"=>"","body"=>"");
            if($appointment->status == "approved") {
                $customerSmsMsg = trans_choice('customer_apppointment_confirm_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
                $employeeSmsMsg = trans_choice('employee_appointment_confirm_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
                $adminSmsMsg = trans_choice('admin_appointment_confirm_notification', null, [
                    "admin" => $admin->first_name." ".$admin->last_name,
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]); 
            } else if ($appointment->status == "cancel") { 
                $customerSmsMsg = trans_choice('customer_appointment_cancel_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $employeeSmsMsg = trans_choice('employee_appointment_cancel_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $adminSmsMsg = trans_choice('admin_appointment_cancel_notification', null, [
                    "admin" => $admin->first_name." ".$admin->last_name,
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
            } else {
                $customerSmsMsg = trans_choice('customer_appointment_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $employeeSmsMsg = trans_choice('employee_appointment_notification', null, [
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);

                $adminSmsMsg = trans_choice('admin_appointment_notification', null, [
                    "admin" => $admin->first_name." ".$admin->last_name,
                    "customer" => $customer->first_name." ".$customer->last_name,
                    "service" => $appointment->service_id,
                    "time" => $startTime.' - '.$endTime,
                    "date" => $appDate,
                    "employee" => $employee->first_name." ".$employee->last_name,
                ]);
            }
            if($appointment->status != "pending") {
                if($smtp->twilio_notify_customer) {
                    $notificationArr = array(
                        'to' => trim($customer->phone),
                        'body' => trim($customerSmsMsg)
                    );
                    Helper::notification($notificationArr);
                }

                if($smtp->twilio_notify_employee) {
                    $notificationArr = array(
                        'to' => trim($employee->phone),
                        'body' => trim($employeeSmsMsg)
                    );
                    Helper::notification($notificationArr);
                }

                if($smtp->twilio_notify_admin) {
                    $notificationArr = array(
                        'to' => trim($admin->phone),
                        'body' => trim($adminSmsMsg)
                    );
                    Helper::notification($notificationArr);
                }
            }
        }
    }

    /**
     * Handle the Appointment "deleted" event.
     *
     * @param  \App\Appointment  $appointment
     * @return void
     */
    public function deleted(Appointment $appointment)
    {
        $google_id = $appointment->google_appointment_id;
        $access_token = employeeSettings::where('employee_id', $appointment->employee_id)->first();
        if(!empty($access_token) && !empty($google_id)) {
            $accessToken = $access_token->access_token;
            $employee = User::where('id', $appointment->employee_id)->first();
            GoogleCal::removeCalendarsEvents($employee->email, $accessToken, $google_id);
        }
    }

    /**
     * Handle the Appointment "restored" event.
     *
     * @param  \App\Appointment  $appointment
     * @return void
     */
    public function restored(Appointment $appointment)
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     *
     * @param  \App\Appointment  $appointment
     * @return void
     */
    public function forceDeleted(Appointment $appointment)
    {
        //
    }
}
