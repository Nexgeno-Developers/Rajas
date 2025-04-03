<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColTwillioCountryColumnToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->tinyInteger('notification')->default(0)->after('razorpay_live_secret');
            $table->tinyInteger('twilio_active_mode')->default(0)->after('notification');
            $table->tinyInteger('twilio_notify_customer')->default(1)->after('twilio_active_mode');
            $table->tinyInteger('twilio_notify_employee')->default(0)->after('twilio_notify_customer');
            $table->tinyInteger('twilio_notify_admin')->default(0)->after('twilio_notify_employee');
            $table->tinyInteger('use_twilio_service_id')->default(0)->after('twilio_notify_admin');
            $table->string('twilio_service_id', 255)->after('use_twilio_service_id');
            $table->string('twilio_sandbox_key', 255)->after('twilio_service_id');
            $table->string('twilio_sandbox_secret', 255)->after('twilio_sandbox_key');
            $table->string('twilio_live_key', 255)->after('twilio_sandbox_secret');
            $table->string('twilio_live_secret', 255)->after('twilio_live_key');
            $table->string('country_name', 255)->after('twilio_live_secret');
            $table->string('country_code', 255)->after('country_name');
            $table->string('twilio_phone', 255)->after('country_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('notification');
            $table->dropColumn('twilio_active_mode');
            $table->dropColumn('twilio_notify_customer');
            $table->dropColumn('twilio_notify_employee');
            $table->dropColumn('twilio_notify_admin');
            $table->dropColumn('use_twilio_service_id');
            $table->dropColumn('twilio_service_id');
            $table->dropColumn('twilio_sandbox_key');
            $table->dropColumn('twilio_sandbox_secret');
            $table->dropColumn('twilio_live_key');
            $table->dropColumn('twilio_live_secret');
            $table->dropColumn('country_name');
            $table->dropColumn('country_code');
            $table->dropColumn('twilio_phone');
        });
    }
}
