<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('user.index', [
            'user' => User::query()->select()->where('id', '=', auth()->id())->get(),
            'posts' => Post::query()->select()->where('user_id', '=', auth()->id())->get(),
            'comments' => Comment::query()->select()->where('user_id', '=', auth()->id())->get(),
        ]);
    }

    public function security(): Factory|View|Application
    {
        return view('user.security', [
            'user' => User::query()->select()->where('id', '=', auth()->id())->get(),
        ]);
    }

    public function updateUsername(): RedirectResponse
    {
        $this->validateUsernameUpdateRequest();

        $user = auth()->user();

        if ($user) {
            /** @var string $username */
            $username = request()->username;
            $user->username = $username;

            $user->save();

            return back()->with('success', "Your username has been changed successfully");
        }

        return back()->with('failure', "Something went wrong");
    }

    public function updateName(): RedirectResponse
    {
        $this->validateNameUpdateRequest();

        $user = auth()->user();

        if ($user) {
            /** @var string $name */
            $name = request()->name;
            $user->name = $name;

            $user->save();

            return back()->with('success', "Your name has been changed successfully");
        }

        return back()->with('failure', "Something went wrong");
    }

    public function updateEmail(): RedirectResponse
    {
        $this->validateEmailUpdateRequest();

        $user = auth()->user();

        if ($user) {
            /** @var string $email */
            $email = request()->email;
            $user->email = $email;
            $user->email_verified_at = null;

            $user->save();

            event(new Registered($user));

            return back()->with('success', "Your email has been changed successfully, please confirm it");
        }

        return back()->with('failure', "Something went wrong");
    }

    public function updatePassword(): RedirectResponse
    {
        $this->validatePasswordUpdateRequest();

        $user = auth()->user();

        if ($user) {
            /** @var string $password */
            $password = request()->password;
            $user->password = Hash::make($password);

            $user->save();

            return back()->with('success', "Your password has been changed successfully");
        }

        return back()->with('failure', "Something went wrong");
    }

    public function deleteAccount(): RedirectResponse
    {
        $user = auth()->user();

        if ($user) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();

            request()->session()->regenerateToken();

            $user->delete();

            return back()->with('success', "Your account has been deleted");
        }

        return back()->with('failure', "Something went wrong");
    }

    protected function validateUsernameUpdateRequest(): array
    {
        /** @var Request $request */
        $request = request();

        return $request->validate([
            'username' => ['required','min:6', 'max:127', Rule::unique('users', 'username')]
        ]);
    }

    protected function validateEmailUpdateRequest(): array
    {
        /** @var Request $request */
        $request = request();

        return $request->validate([
            'email' => ['required', 'email', 'max:127', Rule::unique('users', 'email')]
        ]);
    }

    protected function validateNameUpdateRequest(): array
    {
        /** @var Request $request */
        $request = request();

        return $request->validate([
            'name' => ['required', 'min:6', 'max:127']
        ]);
    }

    protected function validatePasswordUpdateRequest(): array
    {
        /** @var Request $request */
        $request = request();

        return $request->validate([
            'password' => ['required', 'confirmed', 'max:127', Password::defaults()],
        ]);
    }
}
