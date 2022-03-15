<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class SvgProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('svg', function ($expression) {
            if (File::exists(public_path('svg/' . $expression . '.svg'))) {
                return "<?php echo file_get_contents(public_path('svg/{$expression}.svg')); ?>";
            }
        });
    }
}
