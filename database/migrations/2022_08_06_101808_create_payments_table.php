<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appointment_id');
            $table->string('payment_method')->default('offline');
            $table->text('payment_id');
            $table->string('currency');
            $table->double('amount');
            $table->string('payment_type')->nullable();
            $table->integer('payment_detail_id')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('status');
            $table->date('payment_date')->nullable();
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
