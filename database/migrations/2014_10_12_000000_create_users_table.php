<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_user_id')->default(1);
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('phone');
            $table->string('email',100)->unique();
            $table->string('position',50)->nullable();
            $table->string('password',100);
            $table->string('facebook',121)->nullable();
            $table->string('instagram',121)->nullable();
            $table->string('twitter',121)->nullable();
            $table->string('linkedin',121)->nullable();
            $table->boolean('confirmed')->default(0);
            $table->integer('role_id')->unsigned();
            $table->string('profile')->nullable();
            $table->tinyInteger('status')->length(3)->default(1)->comment('0->Inactive,1->active,2->leave');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
                'first_name' => "John",
                'last_name' => "Doe",
                'phone' => '3834300000',
                'email' => 'admin@gmail.com',
                'position' => 'Administrator',
                'password' => bcrypt('12345678'),
                'confirmed' => 1,
                'role_id' => 1,
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
        Schema::dropIfExists('users');
    }
}
