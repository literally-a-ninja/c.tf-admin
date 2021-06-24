<?php

namespace App\Http\Controllers;

use App\Definitions\Campaign;
use App\Http\Requests\CreateStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Models\User;
use Flash;
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
    public function index (Request $request, Campaign $campaignDef)
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
     * Display the specified Statistic.
     *
     * @param  User  $user
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function show (Request $request) : View|Factory|Redirector|RedirectResponse|Application
    {
        /** @var Statistic $contracker */
        $contracker = Statistic::find ($user);

        if (empty($contracker)) {
            Flash::error ('Statistic not found');

            return redirect (route ('contracker.index'));
        }

        return view ('contracker.show')->with ('contracker', $contracker);
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
     * @throws \Exception
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
