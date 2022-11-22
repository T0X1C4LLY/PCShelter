<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserSteamController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('user.steam');
    }

    public function destroy(): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->updateAfterSteamLogout();

        return back()->with('success', "Your steam data has been removed");
    }
}
