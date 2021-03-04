<?php

namespace App\Providers;

use Auth;
use Request;
use Adyen\Config;
use Illuminate\Support\ServiceProvider;
use App\Payment\BarclaycardClient;
use App\Payment\Barclaycard;

class BarclaycardClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Barclaycard::class, function ($app) {
            $paymentClient = new BarclaycardClient(
                new Config(
                    config('payment')
                )
            );

            $paymentClient->setEnvironment(config('payment.environment'));

            $storePayoutClient = new BarclaycardClient(
                new Config(
                    array_merge(
                        config('payment'),
                        config('payment.payout.store')
                    )
                )
            );

            $storePayoutClient->setEnvironment(config('payment.environment'));

            $reviewPayoutClient = new BarclaycardClient(
                new Config(
                    array_merge(
                        config('payment'),
                        config('payment.payout.review')
                    )
                )
            );

            $reviewPayoutClient->setEnvironment(config('payment.environment'));

            return new Barclaycard($paymentClient, $storePayoutClient, $reviewPayoutClient, request());
        });
    }
}
