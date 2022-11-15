<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPaginationInfoException;
use App\Exceptions\SteamResponseException;
use App\Facades\SteamInfo;
use App\Services\Interfaces\HTMLBuilder;
use App\Services\Interfaces\ModelPaginator;
use App\ValueObjects\PaginationInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(
        private readonly HTMLBuilder $builder,
        private readonly ModelPaginator $paginator,
    ) {
    }

    public function index(Request $request): View|Factory|Redirector|string|RedirectResponse|Application
    {
        /** @var int $page */
        $page = request('page') ?? 1;
        $search = $request->input('search') ?? '';
        $perPage = 9;

        $isSteamId = filter_var(
            $search,
            FILTER_VALIDATE_INT
        );

        if ($isSteamId) {
            return redirect('/games/'.$search);
        }

        try {
            $paginationInfo = new PaginationInfo($page, $perPage);
        } catch (InvalidPaginationInfoException $e) {
            return back()->with('failure', $e->getMessage());
        }

        /** @var string $search */
        $gamesPaginated = $this->paginator->games($paginationInfo, $search);

        return $request->ajax() ? $this->builder->createGameDivs($gamesPaginated->items()) : view('games.index');
    }

    public function show(int $steamGameId): Factory|View|Application|RedirectResponse
    {
        try {
            return view('games.show', [
                'game' => SteamInfo::getByGameId($steamGameId),
            ]);
        } catch (SteamResponseException $e) {
            return back()->with('failure', $e->getMessage());
        }
    }
}
