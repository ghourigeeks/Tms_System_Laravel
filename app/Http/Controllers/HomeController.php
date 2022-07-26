<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
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
        $date               = date("Y-m-d");
        $entity             = "daily_report";
        $rec['oSell']       = 0;
        $rec['cSell']       = 0;
        $rec['oPurchase']       = 0;
        $rec['cPurchase']       = 0;

        // $rec['oSell']       = DB::table('customer_has_transactions')
        //                         ->whereDate('customer_has_transactions.created_at','<', $date)
        //                         ->sum('debit');

        // $rec['cSell']       = DB::table('customer_has_transactions')
        //                         ->whereDate('customer_has_transactions.created_at', $date)
        //                         ->sum('debit');

        // $rec['oPurchase']   = DB::table('company_has_transactions')
        //                         ->whereDate('company_has_transactions.created_at','<', $date)
        //                         ->sum('debit');

        // $rec['cPurchase']   = DB::table('company_has_transactions')
        //                         ->whereDate('company_has_transactions.created_at', $date)
        //                         ->sum('debit');

        return view('home',compact('rec'));

        // return view('home');
    }
}
