<?php

namespace App\Http\Controllers;

use App\Definitions\EconCampaign;
use App\Definitions\EconCampaignDD20;
use App\Definitions\EconQuest;
use App\Http\Requests\CreateStatisticRequest;
use App\Models\Interpretations\Campaign;
use App\Models\Interpretations\Quest;
use App\Models\Statistic;
use App\Models\User;
use Exception;
use Flash;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Collection\Collection;
use Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ContrackerController extends AppBaseController
{
    /**
     * Display a listing of the Statistic.
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     */
    public function index (Request $request, EconCampaign $campaignDef)
    {
        return view ('contracker.index');
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function find (Request $request) : RedirectResponse
    {
        try {
            $query = $request->post ('query');
            $player = User::query ()
                ->select ('id')
                ->orWhere ('name', '=', $query)
                ->orWhere ('steamid', '=', $query)
                ->firstOrFail ();

            return Redirect::route ('contracker.view', compact ('player'));
        } catch (ModelNotFoundException $exception) {
            return Redirect::route ('contracker.index')->with ('feedback', [
                'warning' => [
                    [
                        'icon' => 'fas fa-sad-tear',
                        'title' => "We couldn't find your user.",
                    ],
                ],
            ]);
        }
    }

    /**
     * Show the form for creating a new Statistic.
     *
     * @return Response
     */
    public function create ()
    {
        return view ('contracker.create');
    }

    /**
     * Store a newly created Statistic in storage.
     *
     * @param  CreateStatisticRequest  $request
     *
     * @return Response
     */
    public function store (CreateStatisticRequest $request)
    {
        $input = $request->all ();

        /** @var Statistic $contracker */
        $contracker = Statistic::create ($input);

        Flash::success ('Statistic saved successfully.');

        return redirect (route ('contracker.index'));
    }

    /**
     * Control panel for a player's C.TF contrack progression.
     *
     * @param  Request  $request
     * @param  EconCampaignDD20  $econCampaign
     * @param  EconQuest  $econQuest
     * @return Application|Factory|View|RedirectResponse|Redirector
     * @throws FileNotFoundException|\Psr\SimpleCache\InvalidArgumentException
     */
    public function view (
        User $player,
        Request $request,
        EconCampaign $econCampaign,
        EconQuest $econQuest,
    ) : View|Factory|Redirector|RedirectResponse|Application {
        // Load from economy.
        $econCampaign = $econCampaign->findByKey ($request->get ('campaign', 'mvm_directive'), 'title');
        if (! $econCampaign) return redirect (route ('contracker.view', compact ('player')))
            ->with ('feedback', [
                'warning' => [
                    [
                        'icon' => 'fas fa-question',
                        'title' => 'Requested does not exist in the economy.',
                        'message' => 'You were redirected to the default campaign title because your requested campaign does not currently exist within the C.TF economy.',
                    ]
                ],
            ]);

        // TODO(Johnny): Soo... everything else is referenced by it's title in the DB, EXCEPT QUESTS??
        //               For quests, we're using the numeric JSON position WTF.
        $econQuests = isset($econCampaign->quests) ? $econQuest->all ()->whereIn ('title', $econCampaign->quests) : collect();

        // TODO(Johnny): temp cache until singleton is added.
        $key = md5 ("contracker::{$player->steamid}.{$econCampaign->title}");
//        [ $dbCampaign, $dbQuests, $campaignNames ] = Cache::has ($key) ? Cache::get ($key) : [
        [ $dbCampaign, $dbQuests, $campaignNames ] = [
            Campaign::findEcon ($econCampaign->title, $player),
            Quest::findByEcon ($econQuests, $player),
            $econCampaign->all ()->pluck ('name', 'title'),
        ];

        Cache::put ($key, [ $dbCampaign, $dbQuests, $campaignNames ], now ()->addMinutes (5));

        return view ('contracker.view', compact ('player', 'campaignNames', 'econCampaign', 'econQuests'));
    }

    /**
     * Show the form for editing the specified Statistic.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit ($id)
    {
        /** @var Statistic $contracker */
        $contracker = Statistic::find ($id);

        if (empty($contracker)) {
            Flash::error ('Statistic not found');

            return redirect (route ('contracker.index'));
        }

        return view ('contracker.edit')->with ('contracker', $contracker);
    }

    /**
     * Update the specified Statistic in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function update (Request $request, User $player, EconQuest $econQuest) : RedirectResponse
    {
        $questList = collect ($request->post ('quests'));
        $dbQuests = Quest::findByEcon (
            $questList
                ->keys ()
                ->map (fn ($id) => $econQuest->findById ($id))
            , $player
        );

        foreach ($dbQuests as $quest) {
            foreach ($quest->objectives as $index => $_) {
                $quest->setObjective ($index, $questList[$quest->id][$index]);
            }

            $quest->save ();
        }

        return Redirect::route ('contracker.view')
            ->with ('feedback', [
                'success' => [
                    [
                        'icon' => 'fas fa-check',
                        'title' => "Your contracker modifications have been submitted!",
                    ],
                ],
            ]);
    }

    /**
     * Remove the specified Statistic from storage.
     *
     * @param  int  $id
     *
     * @return Response
     * @throws Exception
     *
     */
    public function destroy ($id)
    {
        /** @var Statistic $contracker */
        $contracker = Statistic::find ($id);

        if (empty($contracker)) {
            Flash::error ('Statistic not found');

            return redirect (route ('contracker.index'));
        }

        $contracker->delete ();

        Flash::success ('Statistic deleted successfully.');

        return redirect (route ('contracker.index'));
    }
}
