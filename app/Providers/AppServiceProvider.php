<?php

namespace App\Providers;

use App\Traits\StatusPeriodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    use StatusPeriodeTrait;

    public function boot()
    {

        try {
            $periode = $this->cekperiode();
            if ($periode == false) {
                $periode = 0;
            }
            View::share('periode_aktif', $periode);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
