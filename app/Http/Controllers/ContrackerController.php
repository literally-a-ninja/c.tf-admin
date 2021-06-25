<?php

namespace App\Http\Controllers;

use App\Definitions\EconCampaign;
use App\Definitions\EconCampaignDD20;
use App\Definitions\EconQuest;
use App\Http\Requests\CreateStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Response;

class ContrackerController extends AppBaseController
{
    /**
     * Display a listing of the Statistic.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function index (Request $request, EconCampaign $campaignDef)
    {
        $campaigns = $campaignDef->all ();
        return view ('contracker.index', compact ('campaigns'));
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
     * @throws FileNotFoundException
     */
    public function show (
        Request $request,
        EconCampaignDD20 $econCampaign,
        EconQuest $econQuest,
    ) : View|Factory|Redirector|RedirectResponse|Application {

        // Placeholders for my sanity
        $requestedCampaign = 'mvm_directive';
        $requestedUser = 'Potatofactory';

        // TODO(Johnny): Refactor into User model.
        /** @var $player User */
        $player = User::query ()
            ->orWhere ('name', '=', $requestedUser)
            ->orWhere ('steamid', '=', $requestedUser)
            ->firstOrFail ();

        // Load from economy.
        $econCampaign = $econCampaign->load ('mvm_directive');

        // TODO(Johnny): Soo... everything else is referenced by it's title in the DB, EXCEPT QUESTS??
        //               For quests, we're using the numeric JSON position WTF.
        $econQuests = $econQuest
            ->all ()
            ->mapWithKeys (function ($value, $key) {
                $value['id'] = $key;
                return [ $key => $value ];
            })
            ->whereIn ('title', $econCampaign->quests);

        // REQ(Johnny): Cache this shit, this is expensive to re-run over and over again.
        $campaign = Campaign::findEcon ($econCampaign->title, $player);
        $quests = Quest::findEcon ($econQuests->pluck ('id'), $player);

        return view ('contracker.show', compact ('player', 'econCampaign', 'campaign', 'quests', 'econQuests'));
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
     * @param  int  $id
     * @param  UpdateStatisticRequest  $request
     *
     * @return Response
     */
    public function update ($id, UpdateStatisticRequest $request)
    {
        /** @var Statistic $contracker */
        $contracker = Statistic::find ($id);

        if (empty($contracker)) {
            Flash::error ('Statistic not found');

            return redirect (route ('contracker.index'));
        }

        $contracker->fill ($request->all ());
        $contracker->save ();

        Flash::success ('Statistic updated successfully.');

        return redirect (route ('contracker.index'));
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
