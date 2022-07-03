<?php

namespace App\Http\Controllers;

use App\Services\NewsletterInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(NewsletterInterface $newsletter): Redirector|Application|RedirectResponse
    {
        request()->validate(['email' => ['required', 'email']]);
        try {
            $requestKey = request('email');
            if (is_string($requestKey)) {
                $newsletter->subscribe($requestKey);
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => 'This email could not be added to our mewsletter'
//                'email' => $e->getMessage()
            ]);
        }

        return redirect('/')->with('success', 'You are now signed up for our newsletter');
    }
}
