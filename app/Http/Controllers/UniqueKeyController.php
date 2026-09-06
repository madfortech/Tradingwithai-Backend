<?php

namespace App\Http\Controllers;

use App\Services\UniqueKeyService;
use Illuminate\Http\Request;

class UniqueKeyController extends Controller
{
    public function index(Request $request)
    {
        return view('unique-key', [
            'uniqueKey' => $request->user()->uniqueKey,
            'plainKey'  => session('plain_key'),
        ]);
    }

    public function regenerate(Request $request, UniqueKeyService $uniqueKeyService)
    {
        $user = $request->user();

        $plainKey = $uniqueKeyService->regenerate($user->id);

        return redirect()
            ->route('unique-key')
            ->with('plain_key', $plainKey);
    }

    
}