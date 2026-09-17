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
        $settings = SiteSetting::current();

        return view('front.home', [
            'settings' => $settings,
            'featuredPlayers' => Player::featured()->latest('updated_at')->take(4)->get(),
            'latestNews' => Post::published()
                ->news()
                ->with('category')
                ->latest('published_at')
                ->take(3)
                ->get(),
            'latestBlogs' => Post::published()
                ->blog()
                ->with('category')
                ->latest('published_at')
                ->take(3)
                ->get(),
            'stats' => [
                'players' => Player::published()->count(),
                'countries' => Player::published()->distinct('nationality')->count('nationality'),
                'tournaments' => 24,
                'years' => 15,
            ],
        ]);
    }
}
