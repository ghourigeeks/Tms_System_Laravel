<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Order_history;
use App\Models\Route_plan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $today;
    function __construct()
    {
         $this->today =  date('Y-m-d');
    }

 

    public function fn_time_achieved($order_id,$time_at_loc){
       
        $timeslot       = '';
        $order          = Order::where('id', $order_id)
                            ->select(
                                        'id',
                                        'status_id',
                                        'pickup_timeslot',
                                        'delivery_timeslot'
                                    )
                            ->first();
                         
        // if( ($order->status_id == 1 ) ||  ($order->status_id == 2 )||  ($order->status_id == 3 )||  ($order->status_id == 4 ) ){
        if( (isset($order->status_id)) ){
            if( ( ($order->status_id == 1 ) ||  ($order->status_id == 4 ) )  ){
            
                $timeslot       = $order->pickup_timeslot;
            }else{
              
    
                if(isset($order->delivery_timeslot)){
                    $timeslot       = $order->delivery_timeslot;
                }else{
                    $timeslot       = $order->pickup_timeslot;
                }
               
            }
            if($timeslot != null){
                $timeslot           = (explode("-",$timeslot));
        
                $time_at_loc        = strtotime(trim($time_at_loc));
                $start_time         = strtotime(trim($timeslot[0]));
                $end_time           = strtotime(trim($timeslot[1]));
             
                if($time_at_loc >= $start_time && $time_at_loc <= $end_time){
                    return true;
                }
            }
        }
       
        return false;
        
    }

    public function fetch_dashboard($rider_id){
        // BEGIN::Defining variables
            $totalLocationTarget    = 0;
            $totalLocationAchieved  = 0;
            
            $pickDropTarget         = 0;
            $pickDropAchieved       = 0;

            $pickTarget             = 0;
            $pickAchieved           = 0;

            $dropTarget             = 0;
            $dropAchieved           = 0;

            $onTimeTarget           = 0;
            $onTimeAchieved         = 0;

            $profilePic             = '';
            $profileName            = '';
        // END::Defining variables

        $rider          = Rider::where('id', $rider_id)
                                ->select(
                                            'name',
                                            'image'
                                        )
                                ->first();
                                
                                
                            
        if(!( isset($rider->name) )){
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404);
        }

        $profilePic     = $rider->image;                    
        $profileName    = $rider->name;
       

        $orders         = DB::table('route_plans')
                            ->whereNotNull('route_plans.route')
                            // ->where('route_plans.complete',0)
                            ->where('route_plans.schedule',1)
                            ->whereDate('route_plans.updated_at',$this->today)
                            ->where('route_plans.rider_id',$rider_id)
                            ->get();

        if(!($orders->isEmpty())){
            foreach ($orders as $key => $value) {
                if($value->status_id == 1){
                    if($value->complete == 1){
                        $pickAchieved++;
                    }
                    $pickTarget++;
                }else if($value->status_id == 2){
                        if($value->complete == 1){
                            $dropAchieved++;
                        }
                        $dropTarget++;
                }else if($value->status_id == 3){
                    if($value->complete == 1){
                        $pickDropAchieved++;
                    }
                    $pickDropTarget++;
                }
    
                if($value->complete==1){
                    $chk    = $this->fn_time_achieved($value->id, $value->time_at_loc);
                    if($chk == true){
                        $onTimeAchieved++;
                    }
                }
            }
        }

      

        // BEGIN::Setting variables
            $totalLocationTarget           = ( $pickDropTarget + $pickTarget +$dropTarget );
            $totalLocationAchieved         = ( $pickDropAchieved + $pickAchieved +$dropAchieved );

            $onTimeTarget                  = ( $totalLocationTarget );

            $rec['totalLocationTarget']    = $totalLocationTarget;
            $rec['totalLocationAchieved']  = $totalLocationAchieved;
            
            $rec['pickDropTarget']         = $pickDropTarget;
            $rec['pickDropAchieved']       = $pickDropAchieved;

            $rec['pickTarget']             = $pickTarget;
            $rec['pickAchieved']           = $pickAchieved;

            $rec['dropTarget']             = $dropTarget;
            $rec['dropAchieved']           = $dropAchieved;

            $rec['onTimeTarget']           = $onTimeTarget;
            $rec['onTimeAchieved']         = $onTimeAchieved;

            $rec['profilePic']             = $profilePic;
            $rec['profileName']            = $profileName;
        // END::Setting variables
        if(!($orders->isEmpty())){
            return response($rec, 201);
        }else{
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404); 
        }
       
    }

    public function fetch_rider_history($rider_id, $year, $month){
        // dd($this->today);
        // BEGIN::Defining variables
            $totalLocationTarget    = 0;
            $totalLocationAchieved  = 0;
            
            $pickDropTarget         = 0;
            $pickDropAchieved       = 0;

            $pickTarget             = 0;
            $pickAchieved           = 0;

            $dropTarget             = 0;
            $dropAchieved           = 0;

            $onTimeTarget           = 0;
            $onTimeAchieved         = 0;

            $profilePic             = '';
            $profileName            = '';
        // END::Defining variables

        $rider          = Rider::where('id', $rider_id)
                                ->select(
                                            'name',
                                            'image'
                                        )
                                ->first();
        if($rider == null){
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404);
        }

        $profilePic     = $rider->image;                    
        $profileName    = $rider->name;
       

        $orders         = DB::table('route_plans')
                            // ->where('route_plans.complete',0)
                            ->whereYear('route_plans.created_at', '=', $year)
                            ->whereMonth('route_plans.created_at', '=', $month)
                            ->where('route_plans.rider_id',$rider_id)
                            ->where('route_plans.schedule',1)
                            ->whereNotNull('route_plans.route')
                            ->get();


        foreach ($orders as $key => $value) {
            if($value->status_id == 1){
                if($value->complete == 1){
                    $pickAchieved++;
                }
                $pickTarget++;
            }else if($value->status_id == 2){
                    if($value->complete == 1){
                        $dropAchieved++;
                    }
                    $dropTarget++;
            }else if($value->status_id == 3){
                if($value->complete == 1){
                    $pickDropAchieved++;
                }
                $pickDropTarget++;
            }
            if($value->complete==1){
                $chk    = $this->fn_time_achieved($value->id, $value->time_at_loc);
                if($chk == true){
                    $onTimeAchieved++;
                }
            }
        }

        // BEGIN::Setting variables
            $totalLocationTarget           = ( $pickDropTarget + $pickTarget +$dropTarget );
            $totalLocationAchieved         = ( $pickDropAchieved + $pickAchieved +$dropAchieved );

            $onTimeTarget                  = ( $totalLocationTarget );

            $rec['totalLocationTarget']    = $totalLocationTarget;
            $rec['totalLocationAchieved']  = $totalLocationAchieved;
            
            $rec['pickDropTarget']         = $pickDropTarget;
            $rec['pickDropAchieved']       = $pickDropAchieved;

            $rec['pickTarget']             = $pickTarget;
            $rec['pickAchieved']           = $pickAchieved;

            $rec['dropTarget']             = $dropTarget;
            $rec['dropAchieved']           = $dropAchieved;

            $rec['onTimeTarget']           = $onTimeTarget;
            $rec['onTimeAchieved']         = $onTimeAchieved;

            $rec['profilePic']             = $profilePic;
            $rec['profileName']            = $profileName;
        // END::Setting variables

        return response($rec, 200);
    }

    public function fetch_recently_added_orders($rider_id){
        
        $orders         = DB::table('orders')
                            ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                            ->leftjoin('customer_has_addresses', 'customer_has_addresses.id', '=', 'orders.pickup_address_id')
                            ->select(
                                        'orders.id as order_id',
                                        'orders.order_note as note',
                                        'orders.status_id as status_id',
                                        'orders.status_id as status_id1',
                                        'orders.status_id2 as status_id2',

                                        'customers.id as customer_id',
                                        'customers.name as customer_name',
                                        'customers.contact_no as buttonCall',
                                        'customer_has_addresses.id as address_id',
                                        'customer_has_addresses.address as address',
                                        'customers.permanent_note as permenantNote',
                                        
                                         DB::raw('CONCAT(orders.id,  "-", customers.name) as title'),
                                         DB::raw('CONCAT(customer_has_addresses.latitude,  ", ", customer_has_addresses.longitude) as buttonMap')
                                    )
                            ->where('orders.status_id',1)
                            ->where('orders.status_id2','!=',16)
                            // ->whereNull('orders.status_id2')
                            ->whereNull('orders.updated_by')
                            ->whereDate('orders.created_at',$this->today)
                            ->where('orders.pickup_rider_id',$rider_id)
                            ->get();
                          
        if(($orders->isEmpty())){
            return response([
                'status'    => 'failed',
                'data'      => 'No order found!',
            ], 404); 
        }
            
        foreach ($orders as $key => $value) {
            $orders[$key]->rideTime         = null; 
            $orders[$key]->isNew            = false;
            $orders[$key]->buttonService    = "Pickup";
        }

        return response($orders, 200);
    }
    
    public function count_polybags($order_id){
        $data             = DB::table('order_has_bags')
                                    ->where('order_has_bags.order_id', $order_id)
                                    ->count();
        return $data;
    }
     
    public function fetch_rides($rider_id){

        $ids                = array(); 
        $tot_weight         = 0;
        $blnk_arry          = array();

        $rider              = DB::table('riders')
                                ->leftjoin('hub_has_riders', 'hub_has_riders.rider_id', '=', 'riders.id')
                                ->leftjoin('distribution_hubs', 'distribution_hubs.id', '=', 'hub_has_riders.hub_id')
                                ->select(
                                            'riders.id',
                                            'riders.max_drop_weight',
                                            'distribution_hubs.cus_address'
                                        )
                                        ->where('riders.id',$rider_id)
                                       ->first();
                                       

        // BEGIN:: Set key to update customer address from application or not
        if((isset($rider->cus_address)) && (($rider->cus_address) == 1)){
            $upd_cus_add    = true;
        }else{
            $upd_cus_add    = false;
        }
        // END:: Set key to update customer address from application or not

        if(isset($rider->max_drop_weight)){
            $rider_weight   = $rider->max_drop_weight;
        }else{
            $rider_weight   = 0;
        }
        
        $orders             = DB::table('route_plans')
                                ->orderBy('route_plans.route','ASC' )
                                ->orderBy('route_plans.seq','ASC')
                                ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->leftjoin('time_slots', 'time_slots.id', '=', 'route_plans.timeslot_id')
                                // ->leftjoin('order_has_services', 'order_has_services.order_id', '=', 'orders.id')
                                ->leftjoin('customer_has_addresses', 'customer_has_addresses.id', '=', 'route_plans.address_id')
                                ->leftjoin('statuses', 'statuses.id', '=', 'route_plans.status_id')
                                ->select(
                                            // 'route_plans.route',
                                            // 'route_plans.seq',
                                            'orders.ref_order_id',
                                            'orders.id as order_id',
                                            'orders.order_note as note',
                                            'orders.status_id as status_id1',
                                            'orders.status_id2 as status_id2',

                                            'customers.id as customer_id',
                                            'customers.name as customer_name',
                                            'customers.contact_no as buttonCall',
                                            'customer_has_addresses.id as address_id',
                                            'customer_has_addresses.address as address',
                                            'customers.permanent_note as permenantNote',

                                            'route_plans.id',
                                            'route_plans.complete',
                                            'route_plans.status_id',
                                            'route_plans.time_at_loc',
                                            'route_plans.travel_time as rideTime',

                                            'statuses.name as buttonService',
                                   
                                            // DB::raw('CONCAT(time_slots.start_time," - ", time_slots.end_time ) as time_slot_name'),
                                             DB::raw('CONCAT(orders.id,  "-", customers.name) as title'),
                                             DB::raw('CONCAT(customer_has_addresses.latitude,  ", ", customer_has_addresses.longitude) as buttonMap'),
                                             DB::raw('CONCAT(time_slots.start_time,  "  -  ", time_slots.end_time) as time_slot')
                                            //  DB::raw('(sum(order_has_services.qty)) AS serviceQuantity'),
                                        )
                                ->where('route_plans.schedule',1)
                                ->where('route_plans.is_move_to_hub',0)
                                ->whereNotNull('route_plans.route')
                                ->whereDate('route_plans.updated_at',$this->today)
                                ->where('route_plans.rider_id',$rider_id)
                                ->get();

        if(($orders->isEmpty())){
            $orders = array();
            return response($orders, 404); 
        }

        foreach ($orders as $key => $value) {
            $orders[$key]->isHFQ                = false;
            $orders[$key]->isComplete           = false;

            if( isset($value->ref_order_id) &&  (($value->ref_order_id) != null) ){
                $orders[$key]->isHFQ            = true;
            }

            if( isset($value->complete) &&  (($value->complete) == 1 ) ){
                $orders[$key]->isComplete       = true;
            }

            if(($value->status_id1) != 1) {
                $ord_his        = DB::table('order_histories')
                                    ->select(
                                                'order_histories.order_id'
                                            )
                                    ->where('order_histories.order_id',$value->order_id)
                                    ->where('order_histories.status_id',14) // 14: content packed
                                    ->first();

                if(!(isset($ord_his->order_id))){
                    $orders[$key]->buttonService = "To Be Packed";
                }
            }

            // BEGIN:: if update of customer address by Application is allowed from hub, then check is the customer new ?? 
            if($upd_cus_add){
                $isNew              = DB::table('route_plans')
                                        ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                        ->where('orders.customer_id', '=', $value->customer_id)
                                        ->where('route_plans.complete','!=',0)
                                        ->where('route_plans.schedule',1)
                                        ->count('orders.customer_id');
                if($isNew > 0){
                    $orders[$key]->isNew = false;
                }else{
                    $orders[$key]->isNew = true;
                } 
            }else{
                $orders[$key]->isNew = false;
            }
            // END:: if update of customer address by Application is allowed from hub, then check is the customer new ?? 

            $ord_detail         = DB::table('order_has_services')
                                    ->select(
                                                DB::raw("SUM(order_has_services.qty) as srv_qty"),
                                                DB::raw("SUM(order_has_services.weight) as srv_weight")
                                            )
                                    ->where('order_has_services.order_id', '=',  $orders[$key]->order_id)
                                    ->groupBy('order_has_services.order_id')
                                    ->first();

                         
            // BEGIN:: Append service quatity key in array of orders (Drop / Pick & Drop)
            if(isset($ord_detail->srv_qty)){
                if(($value->status_id) != 1){
                    // $orders[$key]->serviceQuantity = ($ord_detail->srv_qty);
                    
                     $orders[$key]->serviceQuantity = $this->count_polybags($orders[$key]->order_id);
                }
            }
            // END:: calculate service quatity key in array of orders (Drop / Pick & Drop)

            // BEGIN:: Append service weight of orders (pick)
            if(isset($ord_detail->srv_weight)){
                if(($value->status_id) == 1){
                    $wgt    =  ($ord_detail->srv_weight);
                }else{
                    $wgt    =  0;   
                }
            }else{
                $wgt        =  0;
            }
            // END:: calculate service weight of orders (pick)

            if( $tot_weight <= $rider_weight){
                $tot_weight += ($wgt);
                if(($value->status_id) == 1){
                    array_push($ids,($orders[$key]->id));
                }
            }
          
        }

        if((count($ids)> 0)){
            $lst_id  = end($ids);
        }else{
            $lst_id = 0;
        }
       
       


        // converting collection to array
        $orders = $orders->toArray();

        // BEGIN::Creating a new array by pushing all orders alongwith drop off 
            foreach ($orders as $key => $value) {
                array_push($blnk_arry,$value);
                if((count($ids)> 0)){
                    if(($orders[$key]->id) == $lst_id){
                        $tmp     = (object) array(
                            'order_id'      => 0,
                            'title'         => "Drop Off Point",
                            'time'          => ($orders[$key]->time_at_loc),
                            'ids'           => $ids
                        );
                        array_push($blnk_arry,$tmp);
                    }
                }
            }
        // END::Creating a new array by pushing all orders alongwith drop off 
        // dd((count($ids)));

        // converting array to collection
        $orders = collect($blnk_arry);
        return response($orders, 200);
    }


    public function move_to_hub(Request $request){
            // $rider = $request->ids;
          

        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:0',
                'ids'                   => 'required|array',
            ],
            [
                'rider_id'              => 'Please enter rider id',
            ]
        );

        if ($validator->passes()) {   




            if( ((count($request->ids)) > 0)  ){

               

                // 7: moved to hub
                $order_id = 0;
                foreach (($request->ids) as $key => $route_id) {

                    $data           = tap(DB::table('route_plans')
                                        // ->where('route_plans.is_move_to_hub',0)
                                        ->where('route_plans.complete',1)
                                        ->where('route_plans.id',$route_id)
                                        // ->whereIn('route_plans.id',$route_id)
                                        ->whereNotNull('route_plans.route')
                                        ->whereDate('route_plans.updated_at',$this->today)
                                        ->where('route_plans.rider_id',$request->rider_id))
                                        ->update(['route_plans.is_move_to_hub'=> 1])
                                        ->first();

                   
                    if(isset($data->order_id)){
                        $order_id       = $data->order_id;
                        $data           = DB::table('orders')
                                            ->where('orders.id',$order_id)
                                            ->update(['orders.status_id2'=> 7]);

                        // BEGIN::  Storing the Order History
                            $var                        = new Order_history();
                            $var->order_id              = $order_id;
                            $var->type                  = 1;
                            $var->created_by            = $request->rider_id;
                            // $var->detail                = $json_obj;
                            $var->status_id             = 7;
                            $var->save();
                        // END::    Storing the Order History
                    }

                }

                            
            $response = [
                'status'    => "success",
            ];

            return response($response, 200);

            }else{
                return response([
                    'status'    => 'failed',
                    'data'      => 'No orders found!',
                ], 404); 
            }
        }
        $response = [
            'status'    => "failed",
            'error'     => $validator->errors()->all(),
        ];
        return response($response, 404); 
    }


}


