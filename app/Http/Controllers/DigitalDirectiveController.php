<?php

namespace App\Http\Controllers;

use App\Definitions\Mission;
use App\Definitions\Tour;
use App\Models\Derived\Mission as MissionStatistic;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Response;

class DigitalDirectiveController extends AppBaseController
{

    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function index (Request $request)
    {
        return view ('dd20.index');
    }

    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function find (Request $request)
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cmd (Request $request, User $player, Mission $mission)
    {
        switch ($request->post ('action')) {
            case 'reset_cache':
                Http::get ('https://creators.tf/api/IFlushMemory');
                break;

            default:
                break;
        }

        return Redirect::route ('dd20.view', compact ('player'));
    }

    /**
     * @param  Request  $request
     * @param  string  $userId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function view (Request $request, User $player, Tour $tour)
    {
        $missions = collect ([
            $tour->newInstance ('tour_digital_directive_2')->missions (),
            $tour->newInstance ('tour_digital_directive_1')->missions (),
        ]);

        $missions = $missions->flatten ()->groupBy ('map');
        $campaign = Statistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', '=', '[C:mvm_directive]')
            ->firstOrFail ();

        $stats = MissionStatistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', 'LIKE', '[MVMM:%')
            ->get ()
            ->mapWithKeys (function (Statistic $statistic) {
                return [$statistic->name () => $statistic];
            });

        return view ('dd20.view', compact ('player', 'campaign', 'missions', 'stats'));
    }

    public function store (Request $request, User $player, Mission $mission)
    {
        $base32Def = $request->post ('reference');
        $waves = collect ($request->post ('waves', []))->flip ();

        if (! $base32Def) {
            return Redirect::back ()->with ('error', 'Cannot locate mission.');
        }

        $mission->fromJson (base64_decode ($base32Def));

        /* @var $stat MissionStatistic */
        $stat = MissionStatistic::query ()
            ->where ('steamid', '=', $player->steamid)
            ->where ('target', '=', "[MVMM:{$mission->title}]")
            ->firstOrNew ();

        $erase = $request->post ('erase', false);
        $loot = $request->post ('loot', false);

        // {"wave_1":true,"wave_1_once":true,"wave_1_duration":393,"updated":1618099520,"wave_2":true,"wave_2_once":true,"wave_2_duration":261,"wave_3":true,"wave_3_once":true,"wave_3_duration":153,"wave_4":true,"wave_4_once":true,"wave_4_duration":210,"wave_5":true,"wave_5_once":true,"wave_5_duration":248,"wave_6":true,"wave_6_once":true,"wave_6_duration":195,"wave_7":true,"wave_7_once":true,"wave_7_duration":106}
        for ($i = 0; $i < $mission->waves; $i ++) {
            $n = $i + 1;
            // V.m., Completed := (not erasing progress) AND [(giving loot) OR (marked wave as completed)].
            $truth = (! $erase) && ($loot || isset($waves[$n]));
            $stat->markWave ($n, $truth);
        }

        // TODO: Put this in an observer object.
        $progress['updated'] = now ()->getTimestamp ();

        // These need to be set before saving if new.
        if (! $stat->exists) {
            $stat->fill ([
                'steamid' => $player->steamid,
                'target' => "[MVMM:{$mission->title}]",
            ]);
        }

        $stat->save ();

        if ($loot) {
            $this->giveLoot ($player, $mission);
        }

        return Redirect::route ('dd20.view', compact ('player'))
            ->with ('success', "Successfully updated {$player->name}!");
    }

    /**
     * @param  \App\Models\User  $player
     * @param  \App\Definitions\Mission  $mission
     */
    protected function giveLoot (User $player, Mission $mission)
    {
        $apiKey = env ('API_CREATORS_KEY');
        Http::withHeaders ([
            'Access' => "Provider {$apiKey}",
        ])->post ('https://creators.tf/api/IEconomySDK/UserMvMWaveProgress', [
            'steamids' => [$player->steamid],
            'classes' => ['scout'],
            'wave' => $mission->waves,
            'time' => '999',
            'mission' => $mission->title,
        ]);
    }
}
