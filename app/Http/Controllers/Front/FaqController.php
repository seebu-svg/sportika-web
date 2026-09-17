<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('front.faq', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
