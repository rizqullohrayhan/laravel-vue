<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $post = auth()->user()->post()->latest()->get();
        return Inertia::render('posts/Index', [
            'posts' => PostResource::collection($post),
        ]);
    }
}
