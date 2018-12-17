<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 11/16/18
 * Time: 1:08 PM
 */

namespace Arga;

use Arga\Storage\Cloudinary\CloudinaryServiceProvider;
use Arga\Storage\GoogleCloud\GoogleCloudServiceProvider;
use Illuminate\Support\ServiceProvider;

class ArgaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadHelper();
    }

    public function register()
    {
        $this->app->register(CloudinaryServiceProvider::class);
        $this->app->register(GoogleCloudServiceProvider::class);
    }

    private function loadHelper()
    {
        require_once(__DIR__."/../arga/Helpers/helper.php");
    }
}
