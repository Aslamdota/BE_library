<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/redirect';

    /**
     * Define your route model bindings, pattern filters, and other route services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Tambahkan route redirect berdasarkan role di sini
        Route::middleware('web')
            ->group(function () {
                Route::get('/redirect', function () {
                    $role = auth()->user()->role;
                    if ($role === 'admin') {
                        return redirect('/admin-dashboard');
                    } elseif ($role === 'karyawan') {
                        return redirect('/karyawan-dashboard');
                    } else {
                        return redirect('/anggota-dashboard');
                    }
                })->middleware('auth');
            });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }
}
