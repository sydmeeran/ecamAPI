<?php

namespace Arga\Storage\Cloudinary;

use Illuminate\Support\ServiceProvider;

class CloudinaryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $setting = new CloudinaryClient(config('filesystems.disks.cloudinary'));

        $this->app->singleton(CloudinaryClient::class, function () use ($setting) {
            return $setting;
        });
    }

}