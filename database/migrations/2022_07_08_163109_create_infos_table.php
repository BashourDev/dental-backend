<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();

            $table->string('en_welcome_blue_title');
            $table->string('en_welcome_green_title');
            $table->string('en_welcome_subtitle');
            $table->string('en_about_us_title');
            $table->string('en_about_us_subtitle');
            $table->string('en_about_us_description');
            $table->string('en_special_centers_title');
            $table->string('en_special_centers_subtitle');
            $table->string('en_special_companies_title');
            $table->string('en_special_companies_subtitle');
            $table->string('en_address');

            $table->string('ar_welcome_blue_title');
            $table->string('ar_welcome_green_title');
            $table->string('ar_welcome_subtitle');
            $table->string('ar_about_us_title');
            $table->string('ar_about_us_subtitle');
            $table->string('ar_about_us_description');
            $table->string('ar_special_centers_title');
            $table->string('ar_special_centers_subtitle');
            $table->string('ar_special_companies_title');
            $table->string('ar_special_companies_subtitle');
            $table->string('ar_address');

            $table->string('email');
            $table->string('phone');

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
        Schema::dropIfExists('infos');
    }
};
