<?php

namespace App\Providers;

use App\Other\ArrayPagination;
use App\Services\MailchimpNewsletter;
use App\Services\NewsletterInterface;
use Illuminate\Database\Eloquent\Model;
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

        Password::defaults(static function () {
            return Password::min(8)
                ->mixedCase()
                ->uncompromised()
                ->letters()
                ->numbers()
                ->symbols();
        });

        $this->app->bind('ArrayPagination', function () {
            return new ArrayPagination();
        });
    }
}
