<?php

namespace Namest\Likeable;

use Illuminate\Support\ServiceProvider;

/**
 * Class LikeableServiceProvider
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Namest\Likeable
 *
 */
class LikeableServiceProvider extends ServiceProvider
{
    /**
     * Boot up resources
     */
    public function boot()
    {
        // Publish a config file
        $this->publishes([
            __DIR__ . '/../config/likeable.php' => config_path('likeable.php')
        ], 'config');

        // Publish your migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }
}
