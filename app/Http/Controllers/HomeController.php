<?php

namespace App\Http\Controllers;

use App\Definitions\EconCampaignDD20;
use App\Definitions\EconQuest;
use App\Definitions\EconTour;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EconCampaignDD20 $dd20)
    {
//        dd($dd20->newInstance ('mvm_directive')->loadFromDisk ());
//        dd($quest->newInstance ('scrapyard_slaughter')->loadFromDisk ());
//        dd($quest->newInstance ('scrapyard_slaughter')->loadFromDisk ());
        return view('home');
    }
}
