<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('front.home', [
            'settings' => SiteSetting::current(),
            'featuredPlayers' => Player::featured()->latest('updated_at')->take(4)->get(),
            'latestPosts' => Post::published()
                ->with('category')
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
