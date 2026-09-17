<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->input('sort', 'featured');

        $query = Player::published()
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where(function ($q) use ($request) {
                    $term = '%' . $request->string('search') . '%';
                    $q->where('name', 'like', $term)
                        ->orWhere('current_club', 'like', $term)
                        ->orWhere('sport', 'like', $term);
                })
            )
            ->when(
                $request->filled('city'),
                fn ($q) => $q->where('city', $request->string('city'))
            )
            ->when(
                $request->filled('level'),
                fn ($q) => $q->where('level', $request->string('level'))
            )
            ->when(
                $request->filled('sport'),
                fn ($q) => $q->where('sport', $request->string('sport'))
            );

        match ($sort) {
            'newest' => $query->latest('created_at'),
            'alpha' => $query->orderBy('name'),
            'featured' => $query->orderBy('is_featured', 'desc')->orderBy('name'),
            default => $query->latest('created_at'),
        };

        $players = $query->paginate(20)->withQueryString();

        return view('front.players.index', [
            'players' => $players,
            'cities' => Player::published()->distinct()->orderBy('city')->pluck('city')->filter()->values(),
            'levels' => Player::LEVELS,
            'sports' => Player::SPORTS,
        ]);
    }

    public function show(Player $player): View
    {
        abort_unless($player->status === 'published', 404);

        $related = Player::published()
            ->whereKeyNot($player->getKey())
            ->when(
                $player->sport,
                fn ($q) => $q->where('sport', $player->sport),
                fn ($q) => $q->where('position', $player->position)
            )
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('front.players.show', [
            'player' => $player,
            'relatedPlayers' => $related,
        ]);
    }
}
