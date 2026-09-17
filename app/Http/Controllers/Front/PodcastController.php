<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class PodcastController extends Controller
{
    public function index(): View
    {
        return view('front.podcasts.index', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function apply(): View
    {
        return view('front.podcasts.apply', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
