<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_title');
            $table->text('about_company');
            $table->text('address');
            $table->text('email');
            $table->text('phone');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('linkedin');
            $table->string('instagram');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->longText('location')->nullable();
            $table->timestamps();
        });

        DB::table('site_configs')->insert([
            'site_title' => "Appointment Booking System",
            'address' =>'103, Bonanza Trade Centre, East Bonanza Road, Las Vegas, USA, 88901',
            'about_company' => 'About Us Appointment Booking Company',
            'email' =>'booking@gmail.com',
            'phone' => '+19876543210',
            'facebook' =>'https://www.facebook.com/',
            'twitter' =>'https://www.twitter.com/',
            'linkedin' =>'https://in.linkedin.com/',
            'instagram' =>'https://www.instagram.com/',
            'location' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25765.591349056853!2d-115.13562712118132!3d36.17388057976022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c8c34ccd3f00f1%3A0xed9d41fbe9875fec!2sEast%20Las%20Vegas%2C%20Las%20Vegas%2C%20NV%2C%20USA!5e0!3m2!1sen!2sin!4v1705493109583!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
         ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_configs');
        
    }
}
