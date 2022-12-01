<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    public function saveContacts(Request $request)
    {
        Info::query()->first()->update($request->only(['phone', 'email', 'en_address', 'ar_address']));
        return response('ok');
    }

    public function saveEN(Request $request)
    {
        Info::query()->first()->update($request->only([
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
        ]));

        return response('ok');
    }

    public function saveAR(Request $request)
    {
        Info::query()->first()->update($request->only([
            'ar_welcome_blue_title',
            'ar_welcome_green_title',
            'ar_welcome_subtitle',
            'ar_about_us_title',
            'ar_about_us_subtitle',
            'ar_about_us_description',
            'ar_special_centers_title',
            'ar_special_centers_subtitle',
            'ar_special_companies_title',
            'ar_special_companies_subtitle'
        ]));

        return response('ok');
    }

    public function info()
    {
        return response(Info::query()->first());
    }
}
