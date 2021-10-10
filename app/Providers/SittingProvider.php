<?php

namespace App\Providers;

use App\Models\Sitting;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class SittingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sittings',function(){
            return new Sitting();
        });
        $loader = AliasLoader::getInstance();
        $loader->alias('setting',Sitting::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(!App::runningInConsole() && count(Schema::getColumnListing('sittings'))){
            $sittings = Sitting::all();
            foreach ($sittings as  $sitting) {
               Config::set('sittings.'.$sitting->name, $sitting->value);
            }
        }
    }
}
