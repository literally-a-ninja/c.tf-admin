<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Flash;
use Response;

class StatisticController extends AppBaseController
{
    /**
     * Display a listing of the Statistic.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Statistic $statistics */
        $statistics = Statistic::all();

        return view('statistics.index')
            ->with('statistics', $statistics);
    }

    /**
     * Show the form for creating a new Statistic.
     *
     * @return Response
     */
    public function create()
    {
        return view('statistics.create');
    }

    /**
     * Store a newly created Statistic in storage.
     *
     * @param CreateStatisticRequest $request
     *
     * @return Response
     */
    public function store(CreateStatisticRequest $request)
    {
        $input = $request->all();

        /** @var Statistic $statistic */
        $statistic = Statistic::create($input);

        Flash::success('Statistic saved successfully.');

        return redirect(route('statistics.index'));
    }

    /**
     * Display the specified Statistic.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Statistic $statistic */
        $statistic = Statistic::find($id);

        if (empty($statistic)) {
            Flash::error('Statistic not found');

            return redirect(route('statistics.index'));
        }

        return view('statistics.show')->with('statistic', $statistic);
    }

    /**
     * Show the form for editing the specified Statistic.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Statistic $statistic */
        $statistic = Statistic::find($id);

        if (empty($statistic)) {
            Flash::error('Statistic not found');

            return redirect(route('statistics.index'));
        }

        return view('statistics.edit')->with('statistic', $statistic);
    }

    /**
     * Update the specified Statistic in storage.
     *
     * @param int $id
     * @param UpdateStatisticRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStatisticRequest $request)
    {
        /** @var Statistic $statistic */
        $statistic = Statistic::find($id);

        if (empty($statistic)) {
            Flash::error('Statistic not found');

            return redirect(route('statistics.index'));
        }

        $statistic->fill($request->all());
        $statistic->save();

        Flash::success('Statistic updated successfully.');

        return redirect(route('statistics.index'));
    }

    /**
     * Remove the specified Statistic from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Statistic $statistic */
        $statistic = Statistic::find($id);

        if (empty($statistic)) {
            Flash::error('Statistic not found');

            return redirect(route('statistics.index'));
        }

        $statistic->delete();

        Flash::success('Statistic deleted successfully.');

        return redirect(route('statistics.index'));
    }
}
