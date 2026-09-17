<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('front.blogs.index', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function show(string $slug): View
    {
        return view('front.blogs.show', [
            'settings' => SiteSetting::current(),
            'slug' => $slug,
        ]);
    }
}
