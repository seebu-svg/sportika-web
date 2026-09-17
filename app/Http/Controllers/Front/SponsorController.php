<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class SponsorController extends Controller
{
    public function index(): View
    {
        return view('front.sponsors', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
