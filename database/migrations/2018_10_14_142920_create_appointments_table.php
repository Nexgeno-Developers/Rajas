<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('admin_id');
            $table->integer('user_id')->unsigned();
            $table->string('category_id',255)->nullable();
            $table->string('service_id',255);
            $table->date('date');
            $table->time('start_time')->format('h:i');
            $table->time('finish_time')->format('h:i');;
            $table->string('comments');
            $table->string('status')->default('pending')->comment('pending','approved','cancel');
            $table->string('note')->nullable();
            $table->integer('approved_by')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->tinyInteger('appointment_process')->default(0)->comment('0-Complete,1-Processing');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
