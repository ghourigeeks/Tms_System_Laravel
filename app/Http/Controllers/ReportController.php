<?php


namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Sell;
use App\Models\Sell_has_item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer_has_transaction;
use Illuminate\Database\Eloquent\Collection;

class ReportController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:report-list', ['only' => ['index','show']]);
         $this->middleware('permission:report-create', ['only' => ['create','store']]);
         $this->middleware('permission:report-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:report-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $companies          = DB::table('companies')
                                ->orderBy('companies.id')
                                ->select('companies.id',
                                        DB::raw('CONCAT(companies.name, "  -  ", companies.owner_name, "  -  ",companies.address) as name'))
                                ->pluck('name','id')
                                ->all();

        $customers          = DB::table('customers')
                                ->orderBy('customers.id')
                                ->select('customers.id',
                                          DB::raw('CONCAT(customers.name, "  -  ",customers.address) as name'))
                                ->pluck('name','id')
                                ->all();

        return view('reports.index',
                                compact(
                                    'companies',
                                    'customers'
                                )
                            );
        // return view('reports.index');
    }

    public function create()
    {
    }

    public function calc_current_customer_transaction($customer_id,$date){

        $data       = DB::table('customer_has_transactions')
                        ->select(
                            DB::raw('SUM(customer_has_transactions.credit) as credit'),
                            DB::raw('SUM(customer_has_transactions.debit) as debit')
                            )
                        ->where('customer_has_transactions.customer_id', $customer_id)
                        ->whereDate('customer_has_transactions.created_at', $date)
                        ->first(); 
        return $data;
    }

    public function calc_previous_customer_transaction($customer_id,$date){

        $data       = DB::table('customer_has_transactions')
                        ->select(
                            DB::raw('SUM(customer_has_transactions.credit) as credit'),
                            DB::raw('SUM(customer_has_transactions.debit) as debit')
                            )
                        ->where('customer_has_transactions.customer_id', $customer_id)
                        ->whereDate('customer_has_transactions.created_at',"<", $date)
                        ->first(); 

        if($data->debit==null){
            $data->debit=0;
        }
        if($data->credit==null){
            $data->credit=0;
        }

        $previous = ($data->credit - $data->debit);

        return $previous;
    }

    public function calc_current_company_transaction($company_id,$date){

        $data       = DB::table('company_has_transactions')
                        ->select(
                            DB::raw('SUM(company_has_transactions.credit) as credit'),
                            DB::raw('SUM(company_has_transactions.debit) as debit')

                            )
                        ->where('company_has_transactions.company_id', $company_id)
                        ->whereDate('company_has_transactions.created_at', $date)
                        ->first(); 
        return $data;

    }

    public function calc_previous_company_transaction($company_id,$date){

        $data       = DB::table('company_has_transactions')
                        ->select(
                            DB::raw('SUM(company_has_transactions.credit) as credit'),
                            DB::raw('SUM(company_has_transactions.debit) as debit')

                            )
                        ->where('company_has_transactions.company_id', $company_id)
                        ->whereDate('company_has_transactions.created_at',"<", $date)
                        ->first(); 

        if($data->debit==null){
            $data->debit=0;
        }
        if($data->credit==null){
            $data->credit=0;
        }

        $previous = ($data->credit - $data->debit);

        return $previous;
    }

    public function store(Request $request)
    {
        
        if($request['entity']=='company'){
            request()->validate([
                'company_date' => 'required',
            ]);
    
            $rec            = array();
            $date           = $request['company_date'];
            $entity         = "company";
    
            $record         = DB::table('companies')
                                ->orderBy('companies.created_at','ASC')
                                ->select('companies.id','companies.name')
                                ->get();
            
            foreach ($record as $key => $value) {
    
                // Calc and sum company current transaction
                $company_transaction    = $this->calc_current_company_transaction($value->id,$date);
                $credit                 = ($company_transaction->credit!=null) ? $company_transaction->credit:0 ;
                $debit                  = ($company_transaction->debit !=null) ? $company_transaction->debit:0 ;
             
                $previous_balance       = $this->calc_previous_company_transaction($value->id,$date);
                
                // set all the columns for datatables
                $rec[$key] = json_decode(
                                json_encode(
                                    array(
                                    'id'            => $value->id,
                                    'name'          => $value->name,
                                    'debit'         => $debit,        // invoice amount
                                    'credit'        => $credit,       // pay amount
                                    'pbalance'      => $previous_balance   
                                )
                            ), false);
          
            }
        }elseif($request['entity']=='customer'){

            request()->validate([
                'customer_date' => 'required',
            ]);
    
            $rec            = array();
            $date           = $request['customer_date'];
            $entity         = "customer";
    
            $record         = DB::table('customers')
                                ->orderBy('customers.created_at','ASC')
                                ->select('customers.id','customers.name')
                                ->get();
            
            foreach ($record as $key => $value) {
    
                // Calc and sum company current transaction
                $customer_transaction    = $this->calc_current_customer_transaction($value->id,$date);
                $credit                  = ($customer_transaction->credit!=null) ? $customer_transaction->credit:0 ;
                $debit                   = ($customer_transaction->debit !=null) ? $customer_transaction->debit:0 ;
             
                $previous_balance        = $this->calc_previous_customer_transaction($value->id,$date);
                
                // set all the columns for datatables
                $rec[$key] = json_decode(
                                json_encode(
                                    array(
                                    'id'            => $value->id,
                                    'name'          => $value->name,
                                    'debit'         => $debit,        // invoice amount
                                    'credit'        => $credit,       // pay amount
                                    'pbalance'      => $previous_balance   
                                )
                            ), false);
          
            }

        }elseif($request['entity']=='company_single'){
            request()->validate([
                'company_id'         => 'required',
                'company_start_date' => 'required',
                'company_end_date'   => 'required'
            ]);
    
            $rec            = array();
            $company_id     = $request['company_id'];
            // $date           = $request['company_start_date'];
            $date           = "From: ".$request['company_start_date']." To: ".$request['company_end_date'];
            $entity         = "company_single";
            $from           = date($request['company_start_date']);
            $to             = date($request['company_end_date']);
            $rec            = DB::table('company_has_transactions')
                                ->orderBy('company_has_transactions.created_at','ASC')
                                // ->leftjoin('purchases', 'purchases.id', '=', 'company_has_transactions.purchase_id')
                                ->leftjoin('companies', 'companies.id', '=', 'company_has_transactions.company_id')
                                
                                ->select(
                                        'company_id',
                                        'companies.name as name',
                                        'credit',
                                        'debit',
                                        'purchase_id',
                                        'company_has_transactions.created_at as date'
                                        // 'purchases.order_no',
                                        )
                                ->where('company_has_transactions.company_id', $company_id)
                                // ->whereDate('company_has_transactions.created_at', $date)
                                ->whereBetween('company_has_transactions.created_at', [$from, $to])
                                ->get()
                                ->all(); 

                   
                                // dd($rec);
        }elseif($request['entity']=='customer_single'){
            request()->validate([
                'customer_id'         => 'required',
                'customer_start_date' => 'required',
                'customer_end_date'   => 'required'
            ]);
    
            $rec            = array();
            $customer_id     = $request['customer_id'];
            // $date           = $request['company_start_date'];
            $date           = "From: ".$request['customer_start_date']." To: ".$request['customer_end_date'];
            $entity         = "customer_single";
            $from           = date($request['customer_start_date']);
            $to             = date($request['customer_end_date']);
            $rec            = DB::table('customer_has_transactions')
                                ->orderBy('customer_has_transactions.created_at','ASC')
                                ->leftjoin('customers', 'customers.id', '=', 'customer_has_transactions.customer_id')
                                
                                ->select(
                                        'customer_id',
                                        'customers.name as name',
                                        'credit',
                                        'debit',
                                        'sell_id',
                                        'customer_has_transactions.created_at as date'
                                        )
                                ->where('customer_has_transactions.customer_id', $customer_id)
                                ->whereBetween('customer_has_transactions.created_at', [$from, $to])
                                ->get()
                                ->all(); 

                   
                                // dd($rec);
        }elseif($request['entity']=='daily_report'){
            request()->validate([
                'report_date'         => 'required',
            ]);
            
            // old date
            $oDate  =  date('Y-m-d', strtotime('-1 day', strtotime($request['report_date'])));
            
            // current date
            $date               = $request['report_date'];
            $entity             = "daily_report";

            $rec['oSell']       = DB::table('customer_has_transactions')
                                    ->whereDate('customer_has_transactions.created_at','<', $date)
                                    ->sum('debit');

            $rec['cSell']       = DB::table('customer_has_transactions')
                                    ->whereDate('customer_has_transactions.created_at', $date)
                                    ->sum('debit');

            $rec['oPurchase']   = DB::table('company_has_transactions')
                                    ->whereDate('company_has_transactions.created_at','<', $date)
                                    ->sum('debit');

            $rec['cPurchase']   = DB::table('company_has_transactions')
                                    ->whereDate('company_has_transactions.created_at', $date)
                                    ->sum('debit');

                   
        }

        if(empty($rec)){
            return redirect()
                ->route('reports.index')
                ->with('permission','No record found!.');
        }else{
   
            return view('reports.show',compact('rec','date','entity'));
        }

       
     
    }

    public function show($id)
    {
        $data               = DB::table('sells')
                                ->orderBy('sells.created_at','DESC')
                                ->leftjoin('customers', 'customers.id', '=', 'sells.customer_id')
                                ->leftjoin('customer_has_transactions', 'customer_has_transactions.sell_id', '=', 'sells.id')
                                ->leftjoin('payment_methods', 'payment_methods.id', '=', 'customer_has_transactions.payment_method_id')
                                ->select('sells.*',
                                        'customers.name as customer_name',
                                        'customers.contact_no',
                                        'customers.address',
                                        'customer_has_transactions.debit',
                                        'customer_has_transactions.credit',
                                        'customer_has_transactions.payment_detail',
                                        'customer_has_transactions.payment_method_id',
                                        'payment_methods.name as payment_method_name',
                                        )
                                ->where('sells.id', $id)
                                ->first();

        // dd($data);
        $selected_items     = DB::table('sell_has_items')
                                ->leftjoin('units', 'units.id', '=', 'sell_has_items.unit_id')
                                ->leftjoin('items', 'items.id', '=', 'sell_has_items.item_id')
                                ->select('sell_has_items.*',
                                         'items.name as item_name',
                                         'units.name as unit_name')
                                ->where('sell_has_items.sell_id', $id)
                                ->get()
                                ->all();

        // dd($selected_items);

        return view('sells.show',compact('data','selected_items'));
    }

    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
    }

    public function destroy(Request $request)
    {
    }

}
