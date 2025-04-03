<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ScriptController extends Controller
{
    public function index()
    {
        echo '<a href="'.url('api/script/twillio').'">Click Add Twillio Update</a><br><br>';
        echo '<a href="'.url('api/script/site/setting').'">Click Add Site Setting Update</a><br><br>';

    }

    public function twillioUpdate()
    {
        $queries = array(

            '1'=> "ALTER TABLE `settings` 
                                        ADD `timezone` varchar(255) NULL AFTER `razorpay_active_mode`,
                                        ADD `date_format` varchar(255) NULL AFTER `timezone`,
                                        ADD `notification` TINYINT NOT NULL DEFAULT '0' AFTER `razorpay_live_secret`,
                                        ADD `twilio_active_mode` TINYINT NOT NULL DEFAULT '0' AFTER `notification`,
                                        ADD `twilio_notify_customer` TINYINT NOT NULL DEFAULT '1' AFTER `twilio_active_mode`,
                                        ADD `twilio_notify_employee` TINYINT NOT NULL DEFAULT '0' AFTER `twilio_notify_customer`,
                                        ADD `twilio_notify_admin` TINYINT NOT NULL DEFAULT '0' AFTER `twilio_notify_employee`,
                                        ADD `use_twilio_service_id` TINYINT NOT NULL DEFAULT '0' AFTER `twilio_notify_admin`,
                                        ADD `twilio_service_id` varchar(255) NULL AFTER `use_twilio_service_id`,
                                        ADD `twilio_sandbox_key` varchar(255) NULL AFTER `twilio_service_id`,
                                        ADD `twilio_sandbox_secret` varchar(255) NULL AFTER `twilio_sandbox_key`,
                                        ADD `twilio_live_key` varchar(255) NULL AFTER `twilio_sandbox_secret`,
                                        ADD `twilio_live_secret` varchar(255) NULL AFTER `twilio_live_key`,
                                        ADD `twilio_phone` varchar(255) NULL AFTER `twilio_live_secret`;"
            );
        return $this->executeQueries($queries);
    }

    public function executeQueries($queries)
    {
        foreach ($queries  as $query) {
            if (!empty($query)) {
                $resultObj = DB::select($query);
            }
        }
        echo 'Database Updated successfully!!!';exit;
    }

    public function siteSettingUpdate()
    {
        $queries = array(
        '1'=> "ALTER TABLE `site_configs` 
                             ADD `location` LONGTEXT NULL AFTER `favicon`;"
        );
        return $this->executeQueries($queries);  
        echo 'Database Site Setting Updated Successfully!!!';exit;           
    }
}