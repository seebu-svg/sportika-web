<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function joinPlayer(): View
    {
        return view('front.membership.join-player', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function joinBrand(): View
    {
        return view('front.membership.join-brand', [
            'settings' => SiteSetting::current(),
        ]);
    }
}
