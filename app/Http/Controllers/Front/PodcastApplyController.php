<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\PodcastApplication;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PodcastApplyController extends Controller
{
    public function create(): View
    {
        return view('front.podcasts.apply', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'sport' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'pitch' => 'required|string|max:2000',
            'achievements' => 'nullable|string|max:2000',
            'availability' => 'nullable|string|max:500',
        ]);

        PodcastApplication::create($validated);

        return redirect()->route('podcast.apply')
            ->with('success', 'Your podcast application has been received! Our team will review it and contact you if selected.');
    }
}
