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
        $players = Player::published()
            ->when(
                $request->filled('position'),
                fn ($query) => $query->where('position', $request->string('position'))
            )
            ->when(
                $request->filled('nationality'),
                fn ($query) => $query->where('nationality', $request->string('nationality'))
            )
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where(function ($query) use ($request) {
                    $term = '%'.$request->string('search').'%';

                    $query->where('name', 'like', $term)
                        ->orWhere('current_club', 'like', $term);
                })
            )
            ->orderBy('is_featured', 'desc')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('front.players.index', [
            'players' => $players,
            'positions' => Player::POSITIONS,
            'nationalities' => Player::published()
                ->distinct()
                ->orderBy('nationality')
                ->pluck('nationality')
                ->filter()
                ->values(),
        ]);
    }

    public function show(Player $player): View
    {
        abort_unless($player->status === 'published', 404);

        $related = Player::published()
            ->whereKeyNot($player->getKey())
            ->where('position', $player->position)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('front.players.show', [
            'player' => $player,
            'relatedPlayers' => $related,
        ]);
    }
}
