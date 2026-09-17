<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::published()
            ->with(['category', 'author'])
            ->when(
                $request->filled('category'),
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($q) => $q->where('slug', $request->string('category'))
                )
            )
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where(function ($query) use ($request) {
                    $term = '%' . $request->string('search') . '%';
                    $query->where('title', 'like', $term)
                        ->orWhere('excerpt', 'like', $term);
                })
            )
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('front.blogs.index', [
            'settings' => SiteSetting::current(),
            'posts' => $posts,
            'categories' => Category::withPublishedPostCounts()->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $post->load(['category', 'author']);

        $related = Post::published()
            ->with('category')
            ->whereKeyNot($post->getKey())
            ->when(
                $post->category_id,
                fn ($query) => $query->where('category_id', $post->category_id),
                fn ($query) => $query->whereNotNull('category_id')
            )
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('front.blogs.show', [
            'settings' => SiteSetting::current(),
            'post' => $post,
            'relatedPosts' => $related,
        ]);
    }
}
