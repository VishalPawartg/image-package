<?php

namespace VishalPawar\ImageConvert;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        require_once(__DIR__.'/helper/ImageHelper.php');

        $this->mergeConfigFrom(
            __DIR__.'/config/ImageConvert.php', 'ImageConvert'
        );

        $this->publishes([
            __DIR__.'/config/image.php' => config_path('ImageConvert.php'),
        ]);

    }

    public function register()
    {
        
    }

}