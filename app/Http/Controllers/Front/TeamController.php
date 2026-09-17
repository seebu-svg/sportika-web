<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('front.team', [
            'settings' => SiteSetting::current(),
            'members' => TeamMember::active()->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $member = TeamMember::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('front.team-show', [
            'settings' => SiteSetting::current(),
            'member' => $member,
        ]);
    }
}
