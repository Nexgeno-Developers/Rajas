<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('employee_id')->unsigned();
            $table->text('days')->nullable();
            $table->time('start_time')->format('h:i');
            $table->time('finish_time')->format('h:i');
            $table->time('rest_time')->format('h:i');
            $table->time('break_start_time')->format('h:i')->nullable();
            $table->time('break_end_time')->format('h:i')->nullable();
            $table->tinyInteger('status')->length(3)->default(1)->comment('0->Inactive,1->active,2->leave');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        $days = ["0","1","2","3","4","5","6"];
        DB::table('working_hours')->insert([
            'user_id' => 1,
            'employee_id' => 1,
            'days' => json_encode($days),
            'start_time' => '09:00:00',
            'finish_time' =>'18:00:00',
            'rest_time' =>'00:30',
            'break_start_time' =>'13:00:00',
            'break_end_time' =>'13:30:00',
            'status' => 1,
            'created_at' =>date('Y-m-d H:i:s'),
            'updated_at' =>date('Y-m-d H:i:s') 
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_hours');
    }
}
