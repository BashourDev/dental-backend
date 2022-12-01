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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->nullable();

            $table->string('en_name');
            $table->string('en_country');
            $table->string('en_city');
            $table->string('en_address');
            $table->string('en_bio');

            $table->string('ar_name');
            $table->string('ar_country');
            $table->string('ar_city');
            $table->string('ar_address');
            $table->string('ar_bio');

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->boolean('is_activated')->default(false);
            $table->integer('subscription_period')->nullable();
            $table->date('subscription_deadline')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('type');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
