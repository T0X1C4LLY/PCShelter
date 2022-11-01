<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GameCategory;
use App\Models\Genre;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GameFinderController extends Controller
{
    public function index(): Factory|View|Application
    {
        $reviewCategories = [
            'general',
            'music',
            'graphic',
            'atmosphere',
            'difficulty',
            'storyline',
            'relaxation',
            'pleasure',
            'child-friendly',
            'NSFW',
            'gore',
            'unique',
        ];

        return view('gameFinder.index', [
            'genres' => Genre::all(),
            'categories' => GameCategory::all(),
            'reviewCategories' => $reviewCategories,
        ]);
    }

    public function show(Request $request): void
    {
    }
}
