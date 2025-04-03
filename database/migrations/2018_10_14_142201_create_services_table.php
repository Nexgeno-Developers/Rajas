<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('category_id');
            $table->string('name');
            $table->double('price');
            $table->text('description');
            $table->time('duration')->format('h:i');
            $table->tinyInteger('auto_approve')->length(2)->default(0)->comment('0->no,1->yes');
            $table->time('cancel_before')->format('h:i');
            $table->string('image',121)->nullable();
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
        Schema::dropIfExists('services');
    }
}
