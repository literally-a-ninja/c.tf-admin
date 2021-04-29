<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
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
    public function view(Request $request, string $userId)
    {
        $player = User::find($userId);

        $campaign = Statistic::query()
            ->where('steamid', '=', $player->steamid)
            ->where('target', '=', '[C:mvm_directive]')
            ->firstOrFail();

        $missions = Statistic::query()
            ->where('steamid', '=', $player->steamid)
            ->where('target', 'LIKE', '[MVMM:%')
            ->get();

        return view('dd20.view', compact('player', 'campaign', 'missions'));
    }
}
