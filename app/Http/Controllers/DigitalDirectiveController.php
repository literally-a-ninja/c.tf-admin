<?php

namespace App\Http\Controllers;

use App\Definitions\Tour;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;

class DigitalDirectiveController extends AppBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Statistic $statistics */
        $statistics = Statistic::all();

        return view('dd20.index')
            ->with('dd20', $statistics);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function find(Request $request)
    {
        $query = $request->query->get('query');
        $query = "$query";
        $player = User::query()
            ->select('id')
            ->orWhere('name', '=', $query)
            ->orWhere('steamid', '=', $query)
            ->firstOrFail();

        return Redirect::route('dd20.view', compact('player'));
    }

    /**
     * @param Request $request
     * @param string $userId
     *
     * @return Response
     */
    public function view(Request $request, User $player, Tour $tour)
    {
        $missions = collect([
            $tour->newInstance('tour_digital_directive_2')->missions(),
            $tour->newInstance('tour_digital_directive_1')->missions(),
        ]);

        $missions = $missions->flatten()->groupBy('map');
        $campaign = Statistic::query()
            ->where('steamid', '=', $player->steamid)
            ->where('target', '=', '[C:mvm_directive]')
            ->firstOrFail();

        $stats = Statistic::query()
            ->where('steamid', '=', $player->steamid)
            ->where('target', 'LIKE', '[MVMM:%')
            ->get()
            ->mapWithKeys(function(Statistic $statistic)
            {
                return [ $statistic->name() => $statistic ];
            });

        return view('dd20.view', compact('player', 'campaign', 'missions', 'stats'));
    }

    public function store(Request $request, User $player)
    {
        dd($request->query());
    }
}
