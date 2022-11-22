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
        /** @var User $user */
        $user = User::select(['username', 'email', 'email_verified_at', 'created_at'])
            ->where('id', auth()->id())
            ->first();

        return view('user.index', [
            'user' => $user->toArray(),
            'posts' => Post::where('user_id', auth()->id())->count(),
            'comments' => Comment::where('user_id', auth()->id())->count(),
        ]);
    }

    public function security(): Factory|View|Application
    {
        /** @var User $user */
        $user = User::select(['name', 'username', 'email'])->where('id', auth()->id())->first();

        return view('user.security', [
            'user' => $user->toArray(),
        ]);
    }

    public function updateUsername(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required','min:6', 'max:127', Rule::unique('users', 'username')]
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var string $username */
        $username = $request->input('username');
        $user->username = $username;

        $user->save();

        return back()->with('success', "Your username has been changed successfully");
    }

    public function updateName(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'min:6', 'max:127']]);

        /** @var User $user */
        $user = $request->user();

        /** @var string $name */
        $name = $request->input('name');
        $user->name = $name;

        $user->save();

        return back()->with('success', "Your name has been changed successfully");
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:127', Rule::unique('users', 'email')]
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var string $email */
        $email = request()->email;
        $user->email = $email;
        $user->email_verified_at = null;

        $user->save();

        event(new Registered($user));

        return back()->with('success', "Your email has been changed successfully, please confirm it");
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'confirmed', 'max:127', Password::defaults()],]);

        /** @var User $user */
        $user = $request->user();

        /** @var string $password */
        $password = request()->password;
        $user->password = Hash::make($password);

        $user->save();

        return back()->with('success', "Your password has been changed successfully");
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $user->delete();

        return back()->with('success', "Your account has been deleted");
    }
}
