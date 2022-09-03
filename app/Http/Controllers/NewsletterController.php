<?php

namespace App\Http\Controllers;

use App\Services\NewsletterInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(NewsletterInterface $newsletter): Redirector|Application|RedirectResponse
    {
        /** @var Request|null $request */
        $request = request();

        if (!is_null($request)) {
            $request->validate(['email' => ['required', 'email']]);
            try {
                /** @var string $requestKey */
                $requestKey = request('email');
                $newsletter->subscribe($requestKey);
                auth()->user()?->givePermissionTo('unsubscribe');
            } catch (\Exception $e) {
//                throw ValidationException::withMessages([
//                    'email' => 'This email could not be added to our newsletter'
//                ]);
                return back()->with('failure', 'This email could not be added to our newsletter');
            }
        }

        return back()->with('success', 'You are now signed up for our newsletter');
    }

    public function index(): Factory|View|Application
    {
        return view('user.newsletter');
    }

    /**
     * @throws ValidationException
     */
    public function destroy(NewsletterInterface $newsletter): RedirectResponse
    {
        /** @var Request|null $request */
        $request = request();

        if (!is_null($request)) {
            try {
                /** @var string $requestKey */
                $requestKey = request('email');
                $newsletter->unsubscribe($requestKey);
                auth()->user()?->revokePermissionTo('unsubscribe');
            } catch (\Exception $e) {
//                throw ValidationException::withMessages([
//                    'email' => 'This email could not be deleted from newsletter subscription'
//                ]);
                return back()->with('failure', 'This email could not be deleted from newsletter subscription');
            }
        }

        return back();
    }
}
