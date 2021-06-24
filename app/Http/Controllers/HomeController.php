<?php

namespace App\Http\Controllers;

use App\Definitions\CampaignDD20;
use App\Definitions\Quest;
use App\Definitions\Tour;
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
    public function index(CampaignDD20 $dd20)
    {
//        dd($dd20->newInstance ('mvm_directive')->loadFromDisk ());
//        dd($quest->newInstance ('scrapyard_slaughter')->loadFromDisk ());
//        dd($quest->newInstance ('scrapyard_slaughter')->loadFromDisk ());
        return view('home');
    }
}
