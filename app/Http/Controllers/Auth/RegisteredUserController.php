<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\NewsletterInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
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
     * @param NewsletterInterface $newsletter
     * @return RedirectResponse
     *
     */
    public function store(Request $request, NewsletterInterface $newsletter): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:127'],
            'username' => ['required', 'string', 'max:127', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:127', 'indisposable', 'unique:users'],
            'password' => ['required', 'confirmed', 'max:127', Password::defaults()],
        ]);

        /** @var string $password */
        $password = $request->password;

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        Auth::login($user);
        event(new Registered($user));

        $user->assignRole(Role::findByName('user'));

        $users = $newsletter->getAllSubscribers()->members;

        foreach ($users as $email) {
            if ($email->email_address === $user->email) {
                $user->givePermissionTo('unsubscribe');
            }
        }

        return redirect(RouteServiceProvider::HOME)->with(['success' => 'Please confirm email to finish registration']);
    }
}
