<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCodeColumnToSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configs', function (Blueprint $table) {
            $table->string('country_name')->after('email')->nullable();
            $table->string('country_code')->after('country_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configs', function (Blueprint $table) {
            $table->dropColumn('country_name');
            $table->dropColumn('country_code');
        });
    }
}
