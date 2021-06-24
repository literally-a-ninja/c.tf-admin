<?php

namespace App\Providers;

use App\Database\Schema\Definition;
use App\Definitions\Campaign;
use App\Definitions\CampaignDD20;
use App\Definitions\Mission;
use App\Definitions\Quest;
use App\Http\Controllers\ContrackerController;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;

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
        $this->app->when ([Campaign::class, Definition::class, Tour::class])
            ->needs (Filesystem::class)
            ->give (fn () => Storage::disk ('local-def'));

        if ($this->app->environment ('production')) {
            // This is required for some reason.
            URL::forceScheme ('https');
        }
    }
}
