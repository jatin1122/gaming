<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

       // date_default_timezone_set('Europe/London');
        Schema::defaultStringLength(191);
        Blade::directive('icon', function ($iconName) {
            return "
                <svg width='32' height='32'>
                    <use xlink:href='/icon-sprite.svg#<?= $iconName ?>'></use>
</svg>
";
});

Blade::directive('activeLink', function ($routeName) {
return "<?= Route::is($routeName) ? 'is-active' : null ?>";
});

// $this->app->bind('path.public', function() {
// return base_path().'/../public';
// });

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