<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('front.team', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
