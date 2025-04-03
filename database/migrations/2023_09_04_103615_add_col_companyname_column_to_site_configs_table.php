<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColCompanynameColumnToSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configs', function (Blueprint $table) {
            $table->string('company_name')->nullable()->default('ReadyBook')->after('id');
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
            $table->dropColumn('company_name');
        });
    }
}
