<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(50)->create();

         \App\Models\User::query()->create([
             'en_name' => 'admin',
             'en_country' => 'admin',
             'en_city' => 'admin',
             'en_address' => 'admin',
             'en_bio' => 'admin',
             'ar_name' => 'admin',
             'ar_country' => 'admin',
             'ar_city' => 'admin',
             'ar_address' => 'admin',
             'ar_bio' => 'admin',
             'phone' => 'admin',
             'subscription_deadline' => now()->addYears(100),
             'featured' => false,
             'type' => 0,
             'email' => 'admin@tabibalasnan.sy',
             'email_verified_at' => now(),
             'latitude' => 48.137154,
             'longitude' => 11.576124,
             'password' => bcrypt('admin'), // password
             'is_activated' => true,
         ]);

        Info::query()->create([
            'en_welcome_blue_title' => "Find Dentists in ",
            'en_welcome_green_title' => "Your Area!",
            'en_welcome_subtitle' => "We made the search process very easy, which would give you the best results.",
            'en_about_us_title' => "About Us",
            'en_about_us_subtitle' => "Learn More About Who We Are",
            'en_about_us_description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas temporibus reiciendis voluptatem rem quam animi, repellat, quisquam ab ducimus dolorum similique quibusdam fugit nulla placeat eaque ipsum ullam dolores doloremque?",
            'en_special_centers_title' => "Special Doctors",
            'en_special_centers_subtitle' => "Check Out Our Selective Special Doctors",
            'en_special_companies_title' => "Special Companies",
            'en_special_companies_subtitle' => "Check Out Our Selective Special Companies",
            'en_address' => 'address in english',

            'ar_welcome_blue_title' => "Find Dentists in ",
            'ar_welcome_green_title' => "Your Area!",
            'ar_welcome_subtitle' => "We made the search process very easy, which would give you the best results.",
            'ar_about_us_title' => "About Us",
            'ar_about_us_subtitle' => "Learn More About Who We Are",
            'ar_about_us_description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas temporibus reiciendis voluptatem rem quam animi, repellat, quisquam ab ducimus dolorum similique quibusdam fugit nulla placeat eaque ipsum ullam dolores doloremque?",
            'ar_special_centers_title' => "Special Doctors",
            'ar_special_centers_subtitle' => "Check Out Our Selective Special Doctors",
            'ar_special_companies_title' => "Special Companies",
            'ar_special_companies_subtitle' => "Check Out Our Selective Special Companies",
            'ar_address' => 'address in arabic',

            'email' => 'some@email.com',
            'phone' => "+999999999",

        ]);
    }
}
