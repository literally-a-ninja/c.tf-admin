<?php

namespace App\Http\Controllers;

use App\Definitions\Mission;
use App\Definitions\Tour;
use App\Http\Requests\DD20MissionPostRequest;
use App\Models\Derived\Mission as MissionStatistic;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class DigitalDirectiveController extends AppBaseController
{

    public function index () : View|Factory|Application
    {
        return view ('dd20.index');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function find (Request $request) : RedirectResponse
    {
        $query = $request->query->get ('query');
        $query = "$query";
        $player = User::query ()
            ->select ('id')
            ->orWhere ('name', '=', $query)
            ->orWhere ('steamid', '=', $query)
            ->firstOrFail ();

        return Redirect::route ('dd20.view', compact ('player'));
    }

    /**
     * POST /dd20/rpc
     *
     * @param  Request  $request
     * @param  User  $player
     * @param  Mission  $mission
     * @return RedirectResponse
     */
    public function cmd (Request $request, User $player, Mission $mission) : RedirectResponse
    {
        switch ($request->post ('action')) {
            case 'reset_cache':
                Http::get ('https://creators.tf/api/IFlushMemory');
                break;

            default:
                break;
        }

        return Redirect::route ('dd20.view', compact ('player'))
            ->with ('feedback', [
                'success' => [
                    [
                        'icon' => 'fas fa-bomb',
                        'title' => 'Remote command',
                        'message' => 'Your reset cache command on <a href="//creators.tf">Creators.TF</a> has been forwarded successfully.',
                    ]
                ],
            ]);
    }

    /**
     * POST /dd20/:user/
     *
     * @param  Request  $request
     * @param  User  $player
     * @param  Tour  $tour
     * @return Application|Factory|View
     * @throws FileNotFoundException
     */
    public function view (Request $request, User $player, Tour $tour) : View|Factory|Application
    {

        $tours = collect ();
        $missions = collect ();
        foreach ([ 'tour_digital_directive_1', 'tour_digital_directive_2' ] as $tourName) {
            $tour = $tour->newInstance ($tourName)->loadFromDisk ();
            $tours->push ($tour);
            $missions->push (
                $tour
                    ->missions ()
                    ->groupBy ('map')
            );
        }

        $campaign = Statistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', '=', '[C:mvm_directive]')
            ->firstOrFail ();

        $stats = MissionStatistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', 'LIKE', '[MVMM:%')
            ->get ()
            ->mapWithKeys (function (MissionStatistic $mission) {
                return [ $mission->name () => $mission ];
            });

        return view ('dd20.view', compact ('player', 'campaign', 'tours', 'missions', 'stats'));
    }

    /**
     * @param  DD20MissionPostRequest  $request
     * @param  User  $player
     * @return RedirectResponse
     */
    public function store (DD20MissionPostRequest $request, User $player) : RedirectResponse
    {
        $waves = $request->waves ();
        $def = $request->definition ();

        /** @var $mission MissionStatistic */
        $mission = $this
            ->queryMission ($player, $def)
            ->firstOrNew ();

        $shouldOverride = $request->post ('procedure') == 'override';
        $shouldErase = $request->post ('procedure') == 'reset';

        $wavesLeft = $def->waves;
        for ($i = 0, $n = 1; $i < $def->waves; $i ++, $n ++) {
            // V.m., Completed := (not erasing progress) AND [(giving loot) OR (marked wave as completed)].
            $truth = (! $shouldErase) && ($shouldOverride || isset($waves[$n]));
            $wavesLeft -= $truth ? 1 : 0;

            $mission->markWave ($n, $truth);
        }

        $mission->setPlayer ($player);
        $mission->setDef ($def);
        $mission->save ();

        if (! $wavesLeft && $request->shouldProcessLoot ()) {
            $this->giveLoot ($player, $def);
        }

        return Redirect::route ('dd20.view', compact ('player'))
            ->with ('feedback', [
                'success' => [
                    [
                        'icon' => 'fas fa-check',
                        'title' => "Successfully updated {$def->name}!",
                    ]
                ],
            ]);
    }

    /**
     * @param  User  $player
     * @param  Mission  $missionDef
     * @return Builder
     */
    protected function queryMission (User $player, Mission $missionDef) : Builder
    {
        return MissionStatistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', '=', "[MVMM:{$missionDef->title}]");
    }

    /**
     * @param  User  $player
     * @param  Mission  $mission
     */
    protected function giveLoot (User $player, Mission $mission)
    {
        $apiKey = env ('API_CREATORS_KEY');
        Http::withHeaders ([
            'Access' => "Provider {$apiKey}",
        ])->post ('https://creators.tf/api/IEconomySDK/UserMvMWaveProgress', [
            'steamids' => [ $player->steamid ],
            'classes' => [ 'scout' ],
            'wave' => $mission->waves,
            'time' => '999',
            'mission' => $mission->title,
        ]);
    }
}
