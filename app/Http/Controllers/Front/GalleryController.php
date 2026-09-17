<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $items = GalleryItem::query()
            ->when($request->filled('album'), fn ($q) => $q->where('album', $request->string('album')))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->string('type')))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(24)
            ->withQueryString();

        $albums = GalleryItem::distinct()->orderBy('album')->pluck('album')->filter()->values();

        return view('front.gallery', [
            'settings' => SiteSetting::current(),
            'items' => $items,
            'albums' => $albums,
        ]);
    }
}
