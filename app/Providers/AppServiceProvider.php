<?php

namespace App\Providers;

use App\GroupChat;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'group_chat' => GroupChat::class
        ]);

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, auth()->user()->getAuthPassword());
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
