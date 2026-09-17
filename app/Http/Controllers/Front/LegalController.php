<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('front.legal.privacy', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function terms(): View
    {
        return view('front.legal.terms', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
