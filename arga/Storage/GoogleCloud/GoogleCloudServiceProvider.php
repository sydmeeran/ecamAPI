<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:18 PM
 */

namespace Arga\Storage\GoogleCloud;

use Carbon\Laravel\ServiceProvider;

class GoogleCloudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config = new GoogleCloudClient(config('filesystems.disks.gcs'));
        $this->app->singleton(GoogleCloudClient::class, function () use ($config) {
            return $config;
        });
    }
}
