<?php

namespace App\Providers;

use App\Definitions\EconCampaign;
use App\Definitions\EconCampaignDD20;
use App\Definitions\EconQuest;
use App\Definitions\EconTour;
use App\Models\Interpretations\Quest;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register ()
    {
        if ($this->app->isLocal ()) {
            $this->app->register (\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot ()
    {
        $fileSystem = Storage::disk ('local-def');

        $this->app->when ([
            EconCampaign::class,
            EconCampaignDD20::class,
            EconTour::class,
            EconQuest::class,
        ])
            ->needs (Filesystem::class)
            ->give (fn () => $fileSystem);

        if ($this->app->environment ('production')) {
            // This is required for some reason.
            URL::forceScheme ('https');
        }


    }
}
