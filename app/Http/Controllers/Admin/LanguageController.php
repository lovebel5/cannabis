<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class LanguageController
{
    public function switchLanguage($locale)
    {
        $availableLocales = ['en', 'th','mm'];
        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        return redirect('admin');
    }
}
