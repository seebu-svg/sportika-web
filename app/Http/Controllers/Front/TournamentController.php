<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class TournamentController extends Controller
{
    public function index(): View
    {
        return view('front.tournaments.index', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function show(string $slug): View
    {
        return view('front.tournaments.show', [
            'settings' => SiteSetting::current(),
            'slug' => $slug,
        ]);
    }
}
