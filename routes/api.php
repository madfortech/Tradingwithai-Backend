<?php

use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/pages/{slug}', function ($slug) {

    $page = Page::where('slug', $slug)
        ->where('is_published', true)
        ->first();

    if (!$page) {
        return response()->json([
            'status' => false,
            'message' => 'Page not found',
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => [
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
        ],
    ]);
});