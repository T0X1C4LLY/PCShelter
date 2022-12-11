<?php

namespace App\Providers;

use App\Facades\Implementation\ArrayPagination;
use App\Facades\Implementation\SteamInfo;
use App\Services\Creator;
use App\Services\GameFinder;
use App\Services\HTMLBuilder;
use App\Services\Interfaces\Creator as CreatorInterface;
use App\Services\Interfaces\HTMLBuilder as HTMLBuilderInterface;
use App\Services\Interfaces\ModelPaginator as ModelPaginatorInterface;
use App\Services\Interfaces\Newsletter;
use App\Services\Interfaces\Search as SearchInterface;
use App\Services\MailchimpNewsletter;
use App\Services\ModelPaginator;
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
        app()->bind(Newsletter::class, function () {
            $client = new ApiClient();
            $client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us12'
            ]);

            return new MailchimpNewsletter($client);
        });

        app()->bind(HTMLBuilderInterface::class, HTMLBuilder::class);
        app()->bind(CreatorInterface::class, Creator::class);
        app()->bind(ModelPaginatorInterface::class, ModelPaginator::class);
        app()->bind(SearchInterface::class, GameFinder::class);
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

        $this->app->bind('SteamInfo', function () {
            return new SteamInfo();
        });
    }
}
