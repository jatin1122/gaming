<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\DepositsPerDay;
use App\Nova\Metrics\RevenuePerDay;
use Kristories\Novassport\Novassport;
use App\Nova\Metrics\RoomBreakdown;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // We set the timezone to UTC here because as we 
        // store dates in the Europe/London, Nova thinks
        // this is UTC, so adds an hour on. Setting this
        // to UTC essentially converts it back.
        Nova::userTimezone(function() {
            return 'UTC';
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->groups->first(function ($group) {
                return in_array('nova', $group->permissions);
            })->count() > 0;
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [new NewUsers, new DepositsPerDay, new RevenuePerDay, new RoomBreakdown];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new Novassport,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
