<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Invisnik\LaravelSteamAuth\SteamInfo;

class SteamAuthController extends Controller
{
    /**
     * The SteamAuth instance.
     *
     * @var SteamAuth
     */
    protected $steam;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected $redirectURL = '/';

    /**
     * AuthController constructor.
     *
     * @param SteamAuth $steam
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    /**
     * Redirect the user to the authentication page
     *
     * @return RedirectResponse|Redirector
     */
    public function redirectToSteam()
    {
        return $this->steam->redirect();
    }

    /**
     * Get user info and log in
     *
     * @return RedirectResponse|Redirector
     */
    public function handle()
    {
        if ($this->steam->validate()) {
            $info = $this->steam->getUserInfo();

            $user = $this->findOrNewUser($info);

            Auth::login($user, true);

            return redirect($this->redirectURL); // redirect to site
        }
        return $this->redirectToSteam();
    }

    /**
     * Getting user by info or created if not exists
     */
    protected function findOrNewUser(SteamInfo $info): User
    {
        /** @var User $user */
        $user = auth()->user();

        /** @phpstan-ignore-next-line  */
        $user->steamId = $info->steamID64;
        /** @phpstan-ignore-next-line  */
        $user->avatar = $info->avatarfull;
        /** @phpstan-ignore-next-line  */
        $user->steamUsername = $info->personaname;

        $user->save();

        $user->givePermissionTo('delete_steam_data');
        $user->revokePermissionTo("login_to_steam");
        $user->givePermissionTo('add_review');

        return $user;
    }
}
