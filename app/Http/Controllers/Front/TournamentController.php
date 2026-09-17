<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TournamentController extends Controller
{
    public function index(Request $request): View
    {
        $tournaments = Tournament::query()
            ->when($request->filled('sport'), fn ($q) => $q->where('sport', $request->string('sport')))
            ->when($request->filled('city'), fn ($q) => $q->where('city', $request->string('city')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest('start_date')
            ->paginate(12)
            ->withQueryString();

        return view('front.tournaments.index', [
            'settings' => SiteSetting::current(),
            'tournaments' => $tournaments,
            'sports' => Tournament::distinct()->orderBy('sport')->pluck('sport')->filter()->values(),
            'cities' => Tournament::distinct()->orderBy('city')->pluck('city')->filter()->values(),
        ]);
    }

    public function show(string $slug): View
    {
        $tournament = Tournament::where('slug', $slug)->firstOrFail();
        $players = $tournament->participatingPlayers();

        return view('front.tournaments.show', [
            'settings' => SiteSetting::current(),
            'tournament' => $tournament,
            'players' => $players,
        ]);
    }
}
