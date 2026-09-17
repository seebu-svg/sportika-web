<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
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
                    $term = '%'.$request->string('search').'%';

                    $query->where('title', 'like', $term)
                        ->orWhere('excerpt', 'like', $term);
                })
            )
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('front.posts.index', [
            'posts' => $posts,
            'featured' => $request->filled(['category', 'search'])
                ? null
                : Post::published()->with('category')->featured()->latest('published_at')->first(),
            'categories' => Category::withPublishedPostCounts()->orderBy('name')->get(),
        ]);
    }

    public function show(Post $post): View
    {
        // Drafts and scheduled posts stay private on the public site.
        abort_unless(
            $post->status === 'published' && $post->published_at !== null && $post->published_at->isPast(),
            404
        );

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

        return view('front.posts.show', [
            'post' => $post,
            'relatedPosts' => $related,
        ]);
    }
}
