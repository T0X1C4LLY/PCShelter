<?php

namespace App\Http\Controllers;

use App\Services\NewsletterInterface;
use Illuminate\Contracts\Foundation\Application;
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
                if (is_string($requestKey)) {
                    $newsletter->subscribe($requestKey);
                }
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'email' => 'This email could not be added to our newsletter'
//                'email' => $e->getMessage()
                ]);
            }
        }

        return redirect('/')->with('success', 'You are now signed up for our newsletter');
    }
}
