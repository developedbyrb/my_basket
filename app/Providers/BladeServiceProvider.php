<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('admin', function () {
            return "<?php if(auth()->check() && strtolower(auth()->user()->role->name) === 'admin'): ?>";
        });

        Blade::directive('endadmin', function () {
            return '<?php endif; ?>';
        });
    }
}
