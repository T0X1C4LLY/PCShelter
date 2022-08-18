<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'user' => User::query()->select()->where('id', '=', auth()->id())->get(),
            'posts' => Post::query()->select()->where('user_id', '=', auth()->id())->get(),
            'comments' => Comment::query()->select()->where('user_id', '=', auth()->id())->get(),
        ]);
    }

    public function security()
    {
        return view('user.security', [
            'user' => User::query()->select()->where('id', '=', auth()->id())->get(),
        ]);
    }

    public function updateUsername()
    {
        $this->validateUsernameUpdateRequest();

        $user = auth()->user();

        if ($user) {
            $user->username = request()->username;

            $user->save();

            return back()->with('success', "Your username have been changed successfully");
        }

        return back()->with('success', "Something went wrong");
    }

    public function updateName()
    {
        $this->validateNameUpdateRequest();

        $user = auth()->user();

        if ($user) {
            $user->name = request()->name;

            $user->save();

            return back()->with('success', "Your name have been changed successfully");
        }

        return back()->with('success', "Something went wrong");
    }

    public function updateEmail()
    {
        $this->validateEmailUpdateRequest();

        $user = auth()->user();

        if ($user) {
            $user->email = request()->email;
            $user->email_verified_at = null;

            $user->save();

            event(new Registered($user));

            return back()->with('success', "Your email have been changed successfully, please confirm it");
        }

        return back()->with('success', "Something went wrong");
    }

    public function updatePassword()
    {
        $this->validatePasswordUpdateRequest();

        $user = auth()->user();

        if ($user) {
            $user->password = Hash::make(request()->password);

            $user->save();

            return back()->with('success', "Your password have been changed successfully");
        }

        return back()->with('success', "Something went wrong");
    }

    protected function validateUsernameUpdateRequest(): array {
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
            'password' => ['required', 'min:8', 'max:127'],
            'password_confirmation' => ['required:password', 'same:password']
        ]);
    }
}
