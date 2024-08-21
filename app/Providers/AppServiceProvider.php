<?php

namespace App\Providers;

use App\Exceptions\NoNodesAvailableException;
use App\Search\Article\ElasticsearchRepository;
use App\Search\Article\EloquentSearchRepository;
use App\Search\SearchRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        Passport::ignoreRoutes(); //only for simple token

        $this->app->bind(SearchRepository::class, function () {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (! config('services.search.enabled')) {
                return new EloquentSearchRepository();
            }

            return new ElasticsearchRepository(
                $this->app->make(Client::class)
            );
        });

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->setBasicAuthentication(env('ELASTIC_BA_USERNAME', 'elastic'), env('ELASTIC_BA_PASSWORD', 'password'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::enablePasswordGrant();
    }
}
