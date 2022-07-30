<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $loginField = filter_var(
            $request->input('login'),
            FILTER_VALIDATE_EMAIL
        )
            ? 'email'
            : 'username';

        /** @var string $login */
        $login = $request->input('login');
        $request->merge([$loginField => strtolower($login)]);
        $request->validate([
            'email' => ['required_without:username', 'email', 'exists:users,email'],
            'username' => ['required_without:email', 'string', 'exists:users,username'],
        ]);
        $status = Password::sendResetLink(
            $request->only($loginField)
        );
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }
        throw ValidationException::withMessages([
            $loginField => [trans($status)],
        ]);
    }
}
