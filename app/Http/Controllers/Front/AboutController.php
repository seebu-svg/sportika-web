<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('front.about', [
            'settings' => SiteSetting::current(),
            'playerCount' => Player::published()->count(),
            'postCount' => Post::published()->count(),
            'teamMembers' => TeamMember::active()->take(4)->get(),
        ]);
    }
}
