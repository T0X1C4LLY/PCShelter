<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MailchimpNewsletter;
use App\Services\NewsletterInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        app()->bind(NewsletterInterface::class, function () {
            $client = new ApiClient();
            $client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us12'
            ]);

            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::unguard();

        Gate::define('admin', function (User $user) {
            $roles = DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('role_id', 1)
                ->get();
            return !$roles->isEmpty();
        });

        Blade::if('admin', function () {
            /** @var Request $request */
            $request = request();

            return $request->user()?->can('admin');
        });

        Gate::define('creator', function (User $user) {
            $roles = DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('role_id', '<', 3)
                ->get();
            return !$roles->isEmpty();
        });

        Blade::if('creator', function () {
            /** @var Request $request */
            $request = request();

            return $request->user()?->can('creator');
        });

        Blade::if('newsletter', static function () {
            $client = new ApiClient();
            $client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us12'
            ]);

            $users = (new MailchimpNewsletter($client))->getAllSubscribers()->members;

            if (request()->user()) {
                foreach ($users as $email) {
                    if ($email->email_address == request()->user()->email) {
                        return false;
                    }
                }
            }
            return true;
        });

        Password::defaults(static function () {
            return Password::min(8)
                ->mixedCase()
                ->uncompromised()
                ->letters()
                ->numbers()
                ->symbols();
        });
    }
}
