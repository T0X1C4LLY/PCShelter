<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Interfaces\Creator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RegisteredUserController extends Controller
{
    public function __construct(public readonly Creator $creator)
    {
    }

    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:127'],
            'username' => ['required', 'string', 'max:127', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:127', 'indisposable', 'unique:users'],
            'password' => ['required', 'confirmed', 'max:127', Password::defaults()],
        ]);

        /** @var string $name */
        $name = $request->input('name');

        /** @var string $username */
        $username = $request->input('username');

        /** @var string $email */
        $email = $request->input('email');

        /** @var string $password */
        $password = $request->input('password');

        $userData = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];

        $user = $this->creator->creatUser($userData);
        $user->givePermissionTo(Permission::findByName('login_to_steam'));

        Auth::login($user);
        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME)
            ->with(['success' => 'Please confirm email to finish registration']);
    }
}
