<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

<<<<<<< HEAD
=======
use Illuminate\Pagination\Paginator;

>>>>>>> 9bbe46c7fe869ced2b14e1be7895e5f4f60d0475
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        \Illuminate\Pagination\Paginator::useBootstrapFive();
=======
        Paginator::useBootstrapFive();
>>>>>>> 9bbe46c7fe869ced2b14e1be7895e5f4f60d0475
    }
}
