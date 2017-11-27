<?php

namespace App\Providers;

use App\Libraries\WechatTool;
use Illuminate\Support\ServiceProvider;

class WechatToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('WechatTool', function() {
            return new WechatTool();
        });
    }
}
