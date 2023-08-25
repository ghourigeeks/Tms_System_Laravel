<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Revision;
use App\Models\Contest;
use App\Models\Client;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders     = Order::count();
        $revisions  = Revision::count();
        $users      = User::count();
        $clients    = Client::count();
        $contests   = Contest::count();
        $payments   = Order::all()->sum('total_payment');

        return view('home',compact('orders','users','payments','clients','contests','revisions'));

        // return view('home');
    }
}
