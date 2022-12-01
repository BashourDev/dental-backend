<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_welcome_blue_title',
        'en_welcome_green_title',
        'en_welcome_subtitle',
        'en_about_us_title',
        'en_about_us_subtitle',
        'en_about_us_description',
        'en_special_centers_title',
        'en_special_centers_subtitle',
        'en_special_companies_title',
        'en_special_companies_subtitle',
        'en_address',

        'ar_welcome_blue_title',
        'ar_welcome_green_title',
        'ar_welcome_subtitle',
        'ar_about_us_title',
        'ar_about_us_subtitle',
        'ar_about_us_description',
        'ar_special_centers_title',
        'ar_special_centers_subtitle',
        'ar_special_companies_title',
        'ar_special_companies_subtitle',
        'ar_address',

        'email',
        'phone'
    ];

}
