<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\Models\User;

class SteamAuthController extends Controller
{
    public function __construct(
        private readonly SteamAuth $steam,
        private readonly string $redirectUrl = '/',
    ) {
    }

    public function redirectToSteam(): RedirectResponse
    {
        return $this->steam->redirect();
    }

    /**
     * @throws GuzzleException
     */
    public function handle(): Redirector|Application|RedirectResponse
    {
        if (!$this->steam->validate()) {
            return $this->redirectToSteam();
        }

        $info = $this->steam->getUserInfo();

        /** @var User $user */
        $user = auth()->user();

        $user->updateAfterSteamLogin($info);

        return redirect($this->redirectUrl);
    }
}
