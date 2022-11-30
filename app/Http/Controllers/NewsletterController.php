<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Interfaces\Newsletter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class NewsletterController extends Controller
{
    public function __invoke(Request $request, Newsletter $newsletter): Redirector|Application|RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        try {
            /** @var string $email */
            $email = $request->input('email');
            $newsletter->subscribe($email);

            /** @var User $user */
            $user = $request->user();
            $user->givePermissionTo('unsubscribe');
        } catch (\Exception) {
            return back()->with('failure', 'This email could not be added to our newsletter');
        }

        return back()->with('success', 'You are now signed up for our newsletter');
    }

    public function index(): Factory|View|Application
    {
        return view('user.newsletter');
    }

    public function destroy(Request $request, Newsletter $newsletter): RedirectResponse
    {
        try {
            /** @var string $requestKey */
            $requestKey = $request->input('email');
            $newsletter->unsubscribe($requestKey);

            /** @var User $user */
            $user = $request->user();
            $user->revokePermissionTo('unsubscribe');
        } catch (\Exception) {
            return back()->with('failure', 'This email could not be deleted from newsletter subscription');
        }

        return back()->with('success', 'You are no longer subscribed for our newsletter');
    }
}
