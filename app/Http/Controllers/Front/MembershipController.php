<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BrandApplication;
use App\Models\Player;
use App\Models\PlayerApplication;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MembershipController extends Controller
{
    public function joinPlayer(): View
    {
        return view('front.membership.join-player', [
            'settings' => SiteSetting::current(),
            'sports' => Player::SPORTS,
            'levels' => Player::LEVELS,
        ]);
    }

    public function joinBrand(): View
    {
        return view('front.membership.join-brand', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function storePlayer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'cnic' => 'nullable|string|max:20',
            'phone' => 'required|string|max:30',
            'date_of_birth' => 'nullable|date',
            'height_cm' => 'nullable|integer|min:100|max:250',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'level' => 'nullable|string|max:30',
            'club_name' => 'nullable|string|max:255',
            'institution_name' => 'nullable|string|max:255',
            'sport' => 'required|string|max:50',
            'sport_details' => 'nullable|array',
            'achievements' => 'nullable|array',
            'achievements.*.title' => 'nullable|string|max:255',
            'achievements.*.year' => 'nullable|string|max:10',
            'achievements.*.level' => 'nullable|string|max:100',
            'achievements.*.description' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:2000',
            'images' => 'nullable|array|max:3',
            'images.*' => 'nullable|url',
            'video_links' => 'nullable|array|max:3',
            'video_links.*' => 'nullable|url',
            'press_mentions' => 'nullable|array',
            'press_mentions.*.publication' => 'nullable|string|max:255',
            'press_mentions.*.link' => 'nullable|url',
            'press_mentions.*.date' => 'nullable|date',
            'parent_guardian_contact' => 'nullable|string|max:255',
            'consent' => 'accepted',
        ]);

        $validated['consent_given'] = true;
        unset($validated['consent']);

        PlayerApplication::create($validated);

        return redirect()->route('membership.player')
            ->with('success', 'Your application has been submitted successfully! Our team will review it and get back to you soon.');
    }

    public function storeBrand(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'website' => 'nullable|url|max:255',
            'details' => 'nullable|string|max:2000',
            'interest' => 'required|in:Sponsorship,Partnership,Advertising',
            'message' => 'nullable|string|max:2000',
        ]);

        BrandApplication::create($validated);

        return redirect()->route('membership.brand')
            ->with('success', 'Thank you for your interest! Our partnerships team will review your submission and reach out shortly.');
    }
}
