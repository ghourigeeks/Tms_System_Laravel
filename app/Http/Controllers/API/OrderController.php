<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use DB;
use Validator;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Route_plan;
use App\Models\Order_has_bag;
use Illuminate\Http\Request;
use App\Models\Order_history;
use App\Models\Order_has_item;
use App\Models\Order_has_service;
use App\Models\Customer_has_wallet;
use App\Models\Customer_has_address;
use App\Models\Payment_ride;

use Exception;
use App\Models\Payment_ride_history;

use App\Http\Controllers\NotificationController;

class OrderController extends Controller
{
    public $today;
    
    function __construct()
    {
         $this->today =  date('Y-m-d');
    }

    public function create_json_history($id)
    {
        // $id = 36;
        $services       = DB::table('order_has_services')
                                    ->leftjoin('services', 'services.id', '=', 'order_has_services.service_id')
                                    ->where('order_has_services.order_id', $id)
                                    ->select('services.id as service_id',
                                            'services.name as service_name',
                                            'order_has_services.weight as service_weight',
                                            'order_has_services.qty as service_qty')
                                    ->get()
                                    ->all(); 

        
        $record         = array(); 
     
        $tot_weight     = 0;
        $tot_qty        = 0;

        $record['order_id']        = $id ;
        if(isset($services)){
            foreach ($services as $service_key  => $service_value) {

                $items          = DB::table('order_has_items')
                                    ->leftjoin('items', 'items.id', '=', 'order_has_items.item_id')
                                    ->leftjoin('services', 'services.id', '=', 'order_has_items.service_id')
                                    ->where('order_has_items.order_id', $id)
                                    ->where('order_has_items.service_id', $service_value->service_id)
                                    ->select('items.id as item_id',
                                             'items.name as item_name',
                                             'order_has_items.id as ord_itm_id',
                                             'order_has_items.service_id as service_id',
                                             'order_has_items.pickup_qty as pickup_qty',
                                             'order_has_items.note as note',
                                             'services.id as service_id',
                                             'services.name as service_name'
                                             )
                                    ->get()
                                    ->all(); 
                                    $addons = []; 
                foreach ($items as $item_key  => $item_value) {
                    $addons[]      = DB::table('order_has_addons')
                                    ->leftjoin('addons', 'addons.id', '=', 'order_has_addons.addon_id')
                                        ->where('order_has_addons.order_id', $id)
                                        ->where('order_has_addons.ord_itm_id',$item_value->ord_itm_id)
                                        ->select(
                                                'addons.id as addon_id',
                                                'addons.name as addon_name',
                                                'order_has_addons.ord_itm_id as ord_itm_id'
                                                )
                                        ->get()
                                        ->all();

                }


                $record['services'][$service_value->service_name] =  array(
                    'service_id'        => $service_value->service_id,
                    'service_name'      => $service_value->service_name,
                    'service_weight'    => $service_value->service_weight,
                    'service_item_qty'  => $service_value->service_qty,
                    'items'             => $items,
                    'addons'            => $addons 
                ); 


                

                $tot_weight                 += $service_value->service_weight;
                $tot_qty                    +=  $service_value->service_qty;
            
            }  
        }
        $record['tot_weight']               = $tot_weight;
        $record['tot_qty']                  = $tot_qty;

        // dd($record);

        if(isset($record)){
            return json_encode($record);
        }else{
            return 0;
        }
       
    }

    public function fn_time_achieved($order_id,$time_at_loc){
       
        $timeslot       = '';
        $order          = Order::where('id', $order_id)
                            ->select(
                                        'status_id',
                                        'pickup_timeslot',
                                        'delivery_timeslot'
                                    )
                            ->first();

        // if( ($order->status_id == 1 ) ||  ($order->status_id == 2 )||  ($order->status_id == 3 )||  ($order->status_id == 4 ) ){
        if( ($order->status_id == 1 ) ||  ($order->status_id == 4 ) ){
            $timeslot       = $order->pickup_timeslot;
        }else{
            $timeslot       = $order->delivery_timeslot;
        }

        $timeslot           = (explode("-",$timeslot));
   
        $time_at_loc        = strtotime(trim($time_at_loc));
        $start_time         = strtotime(trim($timeslot[0]));
        $end_time           = strtotime(trim($timeslot[1]));

        if($time_at_loc >= $start_time && $time_at_loc <= $end_time){
            return true;
        }
        return false;
        
    }
    
    public function fn_get_addon_amount_by_id($order_id){
        $amount                 = 0;
        $all_addons             =  DB::table('order_has_addons')
                                    ->leftjoin('order_has_items', 'order_has_items.id', '=', 'order_has_addons.ord_itm_id')
                                    ->where('order_has_addons.order_id',$order_id)
                                    ->select(
                                                'order_has_addons.id',
                                                'order_has_addons.order_id',
                                                'order_has_items.pickup_qty',
                                                'order_has_addons.cus_addon_rate as rate',
                                            )
                                    ->get();

        foreach ($all_addons as $key => $value) {
            for ($i=0; $i < $value->pickup_qty; $i++) { 
                $amount += $value->rate;
            }
        }
        return $amount;
                           

    }

    public function fn_get_service_amount_by_id($order_id){
        $data                   = "";
        $tot                    = 0;
        $all_services           =  DB::table('orders')
                                    ->leftjoin('order_has_services', 'order_has_services.order_id', '=', 'orders.id')
                                    ->leftjoin('services', 'services.id', '=', 'order_has_services.service_id')
                                    ->where('order_has_services.order_id',$order_id)
                                    ->select(
                                                'orders.id',
                                                'services.unit_id',
                                                'orders.customer_id',
                                                'order_has_services.qty',
                                                'order_has_services.weight',
                                                'order_has_services.service_id',
                                                'order_has_services.cus_service_rate as service_rate',
                                            )
                                    ->get();

        foreach ($all_services as $key => $value) {
            if($value->unit_id == 1){
                 // If unit is KG:1 then rate will be based on service weight
                $tot            += (($value->weight) * ( $value->service_rate));

            }else if($value->unit_id == 2){
                // If unit is item:2 then rate will be based on item rate which will be different for all items
                $items      =  DB::table('order_has_items')
                                    ->where('order_has_items.order_id',$value->id)
                                    ->where('order_has_items.service_id',$value->service_id)
                                    ->select(
                                                'order_has_items.order_id',
                                                'order_has_items.item_id',
                                                'order_has_items.pickup_qty',
                                                'order_has_items.service_id as service_id',
                                                'order_has_items.cus_item_rate as item_rate',
                                            )
                                    ->get();
                foreach ($items as $item_key => $item_value) {
                    $tot   +=   (($item_value->pickup_qty) * ($item_value->item_rate));
                }
            }else if($value->unit_id == 3){
                // If unit is piece:3 then rate will be based on rate which will be same for all items
                $tot            += (($value->qty) * ( $value->service_rate));
            }
           
        }

        return $tot;
                           

    }

    public function fn_add_vat_charges($amount){
        $vat_amount     = 0;
        $vat            = DB::table('vats')
                            ->select(
                                        'vats.vat'
                                    )
                            ->first();
        if($vat){
            $val        = $vat->vat;
            $vat_amount = ($amount * $val / 100);
        }
        return $vat_amount;
    }

    public function fn_add_delivery_charges($amount){
        $d_amount           = 0;
        $d_charges          = DB::table('delivery_charges')
                                ->select(
                                            'delivery_charges.order_amount',
                                            'delivery_charges.delivery_charges'
                                        )
                                ->first();
        if($d_charges){
            $order_amount   = $d_charges->order_amount; 
            if($amount < $order_amount){
                $d_amount   = $d_charges->delivery_charges;
            }
        }
       return $d_amount;
    }

    public function fetch_pickup($rider_id,$order_id){
        if( !(isset($order_id)) ){
           return response([
                'status'    => 'failed',
                'error'     => "Order id is required!!",
            ], 404);
          
        }else if(!(isset($rider_id)) ){
             return response([
                'status'    => 'failed',
                'error'     => "rider id is required!!",
            ], 404);
        }
            $services_selected  = array();
    
            $tot_qty            = 0;
            $tot_weight         = 0;
            $tot_price          = 0;
    
            // $orders             = DB::table('route_plans')
            //                         ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
            //                         ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
            //                         ->select(
            //                                     'orders.id as order_id',
            //                                     'customers.id as customer_id',
            //                                     'customers.name as customer_name',
            //                                     'customers.permanent_note as PermenantNote',
            //                                     'orders.order_note as Note',
            //                                     DB::raw('CONCAT(orders.id,  "-", customers.name) as title'),
            //                                 )
            //                         ->where('orders.id',$order_id)
            //                         ->where('route_plans.complete',0)
            //                         ->where('route_plans.rider_id',$rider_id)
            //                         ->first();
                                    
                                    
            $orders             = DB::table('orders')
                                    // ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                    ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                    ->select(
                                                'orders.id as order_id',
                                                'customers.id as customer_id',
                                                'customers.name as customer_name',
                                                'customers.permanent_note as PermenantNote',
                                                'orders.order_note as Note',
                                                DB::raw('CONCAT(orders.id,  "-", customers.name) as title'),
                                            )
                                    ->where('orders.id',$order_id)
                                    ->first();
                                     
            if(isset($orders->order_id)){
                $services           = DB::table('customer_has_services')
                                        ->leftjoin('services', 'services.id', '=', 'customer_has_services.service_id')
                                        ->select(
                                                    'services.id as service_id',
                                                    'services.name as service_name',
                                                    // DB::raw('CONCAT("uploads/services/", services.image) as service_image'),
                                                    DB::raw('CONCAT("public/uploads/services/", services.image) as service_image'),
                                                    // DB::raw('CONCAT("api/fetch_items/", services.id) as service_link'),
                                                    
                                                )
                                        ->where('customer_has_services.customer_id',$orders->customer_id)
                                        ->get();
                if(!($services->isEmpty())){
                    foreach ($services as $key => $value) {
                        $services[$key]->service_link   = "api/fetch_items/".$order_id."/".($value->service_id);
                        $data                           = DB::table('order_has_services')
                                                            ->where('order_has_services.service_id', '=', $value->service_id)
                                                            ->where('order_has_services.order_id', '=', $orders->order_id)
                                                            ->first();
    
                        if(isset($data->service_id)){
                            
                            $services[$key]->service_selected   = true;
                            $addon_rate                         = $this->fn_get_addon_amount($orders->order_id,$value->service_id);
                            $service_rate                       = $this->fn_get_service_amount($orders->order_id,$value->service_id);
    
                            $rec['service_id']                  = $value->service_id;
                            $rec['service_name']                = $value->service_name;
                            $rec['pieces']                      = $data->qty;
                            $rec['KG']                          = $data->weight;
                            $rec['price']                       = round(($service_rate + $addon_rate),2);
    
                            $tot_qty                           += $data->qty;
                            $tot_weight                        += $data->weight;
                            $tot_price                         += round(($service_rate + $addon_rate),2);
    
                            array_push($services_selected, $rec);
                        }else{
                            $services[$key]->service_selected = false;
                        }
                    }
    
                }
                $grandtotal['pieces']       = $tot_qty;
                $grandtotal['KG']           = $tot_weight;
                $grandtotal['price']        = $tot_price;
    
    
    
                $orders->Services           = $services ;
                if((isset($services_selected)) && (count($services_selected)> 0)){
    
                    //   get and sum all service / items rates
                    $service_tot              = $this->fn_get_service_amount_by_id($order_id);
    
                    // get and sum all addon rates
                    $addon_tot                = $this->fn_get_addon_amount_by_id($order_id);
    
                    // sum service and addon rates
                    $amount_tot               = ( $service_tot + $addon_tot);
    
                    // summing delvery and vat charges
                    $d_amount                 = $this->fn_add_delivery_charges($amount_tot);
                    $temp_amount              = ($d_amount + $amount_tot);
                    $vat_amount               = $this->fn_add_vat_charges($temp_amount);
    
    
                    $delivery_charges['price']  = round(($d_amount + $vat_amount),2);
                    $grandtotal['price']        = round(($grandtotal['price'] +  $delivery_charges['price']),2);
                    
                    $orders->services_selected  = $services_selected;
                    $orders->delivery_charges   = $delivery_charges;
                    $orders->grandtotal         = $grandtotal;
                }
    
                $orders                     = (array) $orders;
             
                return response($orders, 200);
                    
            }else{
                return response([
                    'status'    => 'failed',
                    'data'      => 'data not found!',
                ], 404);
            }
        
                        
      
    }

    public function fetch_new_pickup($rider_id,$order_id){
    
        $services_selected  = array();

        $tot_qty            = 0;
        $tot_weight         = 0;
        $tot_price          = 0;

        $orders             = DB::table('orders')
                                // ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select(
                                            'orders.id as order_id',
                                            'customers.id as customer_id',
                                            'customers.name as customer_name',
                                            'customers.permanent_note as PermenantNote',
                                            'orders.order_note as Note',
                                            DB::raw('CONCAT(orders.id,  "-", customers.name) as title'),
                                        )
                                ->where('orders.id',$order_id)
                                // ->where('route_plans.complete',0)
                                // ->where('route_plans.rider_id',$rider_id)
                                ->first();
                                
        if(isset($orders->customer_id)){
            $services           = DB::table('customer_has_services')
                                    ->leftjoin('services', 'services.id', '=', 'customer_has_services.service_id')
                                    ->select(
                                                'services.id as service_id',
                                                'services.name as service_name',
                                                // DB::raw('CONCAT("uploads/services/", services.image) as service_image'),
                                                DB::raw('CONCAT("public/uploads/services/", services.image) as service_image'),
                                                // DB::raw('CONCAT("api/fetch_items/", services.id) as service_link'),
                                                
                                            )
                                    ->where('customer_has_services.customer_id',$orders->customer_id)
                                    ->get();
                                 
            foreach ($services as $key => $value) {
                $services[$key]->service_link = "api/fetch_items/".$order_id."/".($value->service_id);
                $data           = DB::table('order_has_services')
                                    ->where('order_has_services.service_id', '=', $value->service_id)
                                    ->where('order_has_services.order_id', '=', $orders->order_id)
                                    ->first();

                if($data){
                    $services[$key]->service_selected   = true;
                    $service_rate                       = $this->fn_get_addon_amount($orders->order_id,$value->service_id);
                    $addon_rate                         = $this->fn_get_service_amount($orders->order_id,$value->service_id);

                    $rec['service_id']                  = $value->service_id;
                    $rec['service_name']                = $value->service_name;
                    $rec['pieces']                      = $data->qty;
                    $rec['KG']                          = $data->weight;
                    $rec['price']                       = ($service_rate + $addon_rate);

                    $tot_qty                           += $data->qty;
                    $tot_weight                        += $data->weight;
                    $tot_price                         += ($service_rate + $addon_rate);

                    array_push($services_selected, $rec);
                }else{
                    $services[$key]->service_selected = false;
                }
            }

          
            $grandtotal['pieces']       = $tot_qty;
            $grandtotal['KG']           = $tot_weight;
            $grandtotal['price']        = $tot_price;

            $orders->Services           = $services ;
            if(count($services_selected)> 0){
                $orders->services_selected   = $services_selected;
                $orders->grandtotal         = $grandtotal;
            }

            $orders                     = (array) $orders;

            return response($orders, 200);
                
        }else{
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404);
        }
                              
      
    }

    public function fn_get_addon_amount($order_id,$service_id){
        $amount                 = 0;
        $all_addons             =  DB::table('order_has_addons')
                                    ->leftjoin('order_has_items', 'order_has_items.id', '=', 'order_has_addons.ord_itm_id')
                                    ->where('order_has_addons.order_id',$order_id)
                                    ->where('order_has_addons.service_id',$service_id)
                                    ->select(
                                                'order_has_addons.id',
                                                'order_has_addons.order_id',
                                                'order_has_items.pickup_qty',
                                                'order_has_addons.cus_addon_rate as rate',
                                            )
                                    ->get();

        foreach ($all_addons as $key => $value) {
            for ($i=0; $i < $value->pickup_qty; $i++) { 
                $amount += $value->rate;
            }
        }
        return $amount;
    }

    public function fn_get_service_amount($order_id,$service_id){
        $data                   = "";
        $tot                    = 0;
        $all_services           =  DB::table('order_has_services')
                                    // ->leftjoin('order_has_services', 'order_has_services.order_id', '=', 'orders.id')
                                    ->leftjoin('services', 'services.id', '=', 'order_has_services.service_id')
                                    ->where('order_has_services.service_id',$service_id)
                                    ->where('order_has_services.order_id',$order_id)
                                    ->select(
                                                'order_has_services.order_id as id',
                                                'services.unit_id',
                                                // 'orders.customer_id',
                                                'order_has_services.qty',
                                                'order_has_services.weight',
                                                'order_has_services.service_id',
                                                'order_has_services.cus_service_rate as service_rate',
                                            )
                                    ->get();

        foreach ($all_services as $key => $value) {
            if($value->unit_id == 1){
                 // If unit is KG:1 then rate will be based on service weight
                $tot            += (($value->weight) * ( $value->service_rate));
            }else if($value->unit_id == 2){
                // If unit is item:2 then rate will be based on item rate which will be different for all items
                $items      =  DB::table('order_has_items')
                                    ->where('order_has_items.order_id',$value->id)
                                    ->where('order_has_items.service_id',$value->service_id)
                                    ->select(
                                                'order_has_items.order_id',
                                                'order_has_items.item_id',
                                                'order_has_items.pickup_qty',
                                                'order_has_items.service_id as service_id',
                                                'order_has_items.cus_item_rate as item_rate',
                                            )
                                    ->get();
                foreach ($items as $item_key => $item_value) {
                    $tot   +=   (($item_value->pickup_qty) * ($item_value->item_rate));
                }
            }else if($value->unit_id == 3){
                // If unit is piece:3 then rate will be based on rate which will be same for all items
                $tot            += (($value->qty) * ( $value->service_rate));
            }
           
        }
        return $tot;
    }

    public function fetch_items($order_id, $service_id){
        $orders             = '';
        $orders             = DB::table('route_plans')
                                ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select(
                                            'customers.id as customer_id',
                                        )
                                ->where('orders.id',$order_id)
                                ->where('route_plans.complete',0)
                                ->first();
                                
        if(!(isset($orders->customer_id))){
           $rec             = DB::table('orders')
                                // ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                // ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select(
                                            'orders.customer_id as customer_id',
                                        )
                                ->where('orders.id',$order_id)
                                // ->where('route_plans.complete',0)
                                ->first();  
                                
            $orders  = $rec;
                               
        }
       
       

        $services           = DB::table('services')
                                ->select(
                                            'services.unit_id',
                                        )
                                ->where('services.id',$service_id)
                                ->first();
                                
        if($services == null){
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404);
        }
        $selected_items      = DB::table('order_has_items')
                                // ->leftjoin('items', 'items.id', '=', 'order_has_items.item_id')
                                ->select(
                                            'order_has_items.item_id',
                                            'order_has_items.pickup_qty'
                                        )
                                ->where('order_has_items.service_id',$service_id)
                                ->where('order_has_items.order_id',$order_id)
                            
                                ->get();

        $selected_services  = DB::table('order_has_services')
                                // ->leftjoin('items', 'items.id', '=', 'order_has_items.item_id')
                                ->select(
                                            'order_has_services.weight'
                                        )
                                ->where('order_has_services.service_id',$service_id)
                                ->where('order_has_services.order_id',$order_id)
                            
                                ->first();

                                
        if($services->unit_id == 2){
            $items      = DB::table('customer_has_items')
                            ->leftjoin('customers', 'customers.id', '=', 'customer_has_items.customer_id')
                            ->orderBy('items.id')
                            ->leftjoin('items', 'items.id', '=', 'customer_has_items.item_id')
                            ->where('customer_has_items.service_id',$service_id)
                            ->where('customers.id',$orders->customer_id)
                            ->select(
                                        'items.id as id',
                                        'items.name as title',
                                        
                                    )
                            ->get();
        }else{
            $items      = DB::table('service_has_items')
                            ->orderBy('items.id')
                            ->leftjoin('items', 'items.id', '=', 'service_has_items.item_id')
                            ->where('service_has_items.service_id',$service_id)
                            ->select(
                                        'items.id as id',
                                        'items.name as title',
                                    )
                            ->get();
        }

        foreach ($items as $key => $value) {
            $items[$key]->quantity = 0;
            foreach ($selected_items as $s_key => $s_value) {
                if($s_value->item_id  == $value->id){
                    $items[$key]->quantity = $s_value->pickup_qty;
                }
            }
         
        }

        $data                   = array();
        $data['items']          = $items;

        if( (isset($selected_services->weight))  && (($selected_services->weight) >0)){
            $data['weight']     = $selected_services->weight;
        }else{
            $data['weight']     = 0;
        }
       


        return response($data, 200);

    }

    // get customer all services
    public function get_cus_services($customer_id){
        $services   = DB::table('customer_has_services')
                        ->where('customer_has_services.customer_id', $customer_id)
                        ->select(
                                    'customer_has_services.service_id',
                                    'customer_has_services.service_rate'
                                )
                        ->get();
        return  $services;
    }

    // these are special items like "dry and clean" whose rates are stored in customer_has_items
    public function get_cus_spcl_items($customer_id){

        $items      = DB::table('customer_has_items')
                        ->where('customer_has_items.customer_id', $customer_id)
                        ->select(
                                    'customer_has_items.item_id',
                                    'customer_has_items.item_rate',
                                    'customer_has_items.service_id'
                                )
                        ->get();
        return  $items;
    }

    // get customer service rate
    public function get_service_rate($cus_services, $service_id){
        foreach ($cus_services as $key => $value) {
            if($value->service_id == $service_id ){
                return $value->service_rate;
            }
        }
        return 0;
    }

    // these are general items like "wash and fold" whose rates are stored in service_has_items
    public function get_cus_gen_items($service_id){

        $items      = DB::table('service_has_items')
                        ->where('service_has_items.service_id', $service_id)
                        ->select(
                                    'service_has_items.item_id',
                                    'service_has_items.item_rate',
                                    'service_has_items.service_id'
                                )
                        ->get();
        return  $items;
    }

     // get customer item rate 
    public function get_item_rate($cus_items, $service_id, $item_id){
        foreach ($cus_items as $key => $value) {
            if(($value->service_id == $service_id ) && ($value->item_id == $item_id)){
                return $value->item_rate;
            }
        }
        return false;
    }


    public function store_items(Request $request){
       
        // dd($request->items_selected);
        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:0',
                'order_id'              => 'required|numeric|min:0',
                'service_id'            => 'required|numeric|min:0',
                'weight'                => 'required|min:0',
                // 'items_selected'        => 'required|array'
            ],
            [
                'rider_id'              => 'Please enter rider id',
            ]
        );

        if ($validator->passes()) {
            $tot_qty                = 0;

             // get all services with rates

             $rec                        = Order::select('customer_id')->find($request->order_id);

             $cus_services               = $this->get_cus_services($rec->customer_id);
           
             // customer special items with rates
             $cus_spcl_items             = $this->get_cus_spcl_items($rec->customer_id);

            $services                   = DB::table("order_has_services")
                                            ->where('order_id', '=', $request->order_id)
                                            ->where('service_id', '=', $request->service_id)
                                            ->delete();
                                        
            $items                      = DB::table("order_has_items")
                                            ->where('order_id', '=', $request->order_id)
                                            ->where('service_id', '=', $request->service_id)
                                            ->delete();

            if(count($request->items_selected)>0){
                foreach($request->items_selected as $item_key => $item_value){
                    $item                = new Order_has_item();
                    $item->order_id      = $request->order_id;
                    $item->service_id    = $request->service_id;
                    $item->item_id       = $item_value['id'];
                    $item->pickup_qty    = $item_value['quantity'];

                     // call customer special items (like: Dye and clean) from "customer_has_items" table
                     $itm_rate            =  $this->get_item_rate($cus_spcl_items, $request->service_id, $item_value['id']);
                     if($itm_rate ==  false){
                         // call customer general items from "service_has_items" table
                         $cus_gen_items   = $this->get_cus_gen_items($request->service_id);
                         $itm_rate        = $this->get_item_rate($cus_gen_items, $request->service_id, $item_value['id']);
                     }
                  
                    $item->cus_item_rate = $itm_rate;
                    $item->save();
                    $tot_qty            += $item_value['quantity'];
    
                }

                $var                    = new Order_has_service();
                $var->order_id          = $request->order_id;
                $var->service_id        = $request->service_id;
                $var->qty               = $tot_qty;
                $var->weight            = $request->weight;
                $var->cus_service_rate  = $this->get_service_rate($cus_services, $request->service_id);
                $var->save();
                $response = [
                    'status'    => "success",
                ];
                return response($response, 201);
            }else{
                $response = [
                    'status'    => "success",
                ];
                return response($response, 201); 
            }
        }
        $response = [
            'status'    => "failed",
            'error'     => $validator->errors()->all(),
        ];
        return response($response, 201);
    }

    public function get_address($latitude, $longitude){
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&key=AIzaSyAGCJNMbn6TMfqsSMCI3ACMDz_SkTrAhSk'); 
        $output             = json_decode($geocodeFromLatLong);
        $status             = $output->status;
    
        //Get address from json data
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        //Return address of the given latitude and longitude
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }

    public function confirm_pickup(Request $request){
   
        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:0',
                'order_id'              => 'required|numeric|min:0'
            ],
            [
                'rider_id'              => 'Please enter rider id',
            ]
        );

        if ($validator->passes()) {
            $tst = 0;
            $data                       = Order::find($request->order_id);

            if( (isset($data->status_id2)) && ( ($data->status_id2) == 16) ){
                return response([
                        'status'    => 'failed',
                        'error'     => "Order has been cancelled from hub!",
                ], 404);

            }

            
            $input                      = $request->all();
            
            // $order['order_note']        = $request->order_note;
            $order['rider_note']        = $request->order_note;
            $order['status_id']         = 4;

            if(($data->updated_by) == null){
                $tst = 1;
            }

            if( $tst == 1){
                $order['status_id2']    = 7;
            }

            $upd                        = $data->update($order);
           

            // BEGIN::updateing route-plans
            $rec                       = DB::table('route_plans')
                                            ->where('route_plans.order_id', $request->order_id)
                                            ->where('route_plans.rider_id', $request->rider_id)
                                            ->where('route_plans.complete', 0)
                                            ->where('route_plans.schedule', 1)
                                            ->update([
                                                        'route_plans.complete'=>1,
                                                        'route_plans.time_at_loc' => (date("H:i:s"))
                                                    ]);
            // END::updateing route-plans
                                                
            if($rec || $upd){
                    $json_obj                   = $this->create_json_history($request->order_id);
                // BEGIN::  Storing the Order History
                    $val                        = new Order_history();
                    $val->order_id              = $request->order_id;
                    $val->type                  = 1;
                    $val->created_by            = $request->rider_id;
                    $val->detail                = $json_obj;
                    $val->status_id             = 4;
                    $val->save();
                // END::    Storing the Order History

                if( $tst == 1){ // order is created by rider and this order has to directly move to hub.
                    // BEGIN::  Storing the Order History
                        $var                        = new Order_history();
                        $var->order_id              = $request->order_id;
                        $var->type                  = 1;
                        $var->created_by            = $request->rider_id;
                        $var->detail                = $json_obj;
                        $var->status_id             = 7;
                        $var->save();
                    // END::    Storing the Order History
                }


                // BEGIN::update the customer lat and long, if customer is new 
                if( (isset($request->latitude)) && (isset($request->longitude)) && (isset($request->address_id)) ){
                    $customer_id            = $data->customer_id;
                    $recd                    = Customer_has_address::find($request->address_id);
                    if(isset($recd->latitude)){
                        // $address                = $this->get_address(($request->latitude), ($request->longitude));
                        $record['latitude']     = $request->latitude;
                        $record['longitude']    = $request->longitude;
                        // $record['address']      = $request->address;
                                                 $recd->update($record);
                    }
                    
                }
                // END::update the customer lat and long, if customer is new 

            }

            // BEGIN::send pickup detail by sms
            if(isset($request->order_id)){
                (new NotificationController)->pickup_detail($request->order_id);
            }
            // END::send pickup detail by sms
            

            $response = [
                'status'    => "success",
            ];
            return response($response, 200);
        }
     
        return response([
            'status'    => 'failed',
            'error'     => $validator->errors()->all(),
        ], 404);
    }

    public function count_polybags($order_id){
        $data             = DB::table('order_has_bags')
                                    ->where('order_has_bags.order_id', $order_id)
                                    ->count();
        return $data;
    }

    public function fetch_polybags($order_id, $tot_bags){
        $k = 1;
        $data       = DB::table('order_has_bags')
                        ->select(
                                    'order_has_bags.id as polybag_id',
                                    DB::raw('CONCAT(order_has_bags.id,  "-", order_has_bags.order_id) as polybag_name')                             
                                )
                        ->where('order_has_bags.order_id', $order_id)
                        ->get()
                        ->all();


        if($data){
            foreach ($data as $key => $value) {
                $data[$key]->polybag_number   = $k++ . " of ". $tot_bags;
            }
            $data             = (array)$data;
            return $data;
        }

        return null;
    }

    public function fn_reg_orders_rep($rider_id){
        if( (!(isset($rider_id))) ||( $rider_id < 1)){
            return response([
                'status'    => 'failed',
                'data'      => 'rider id not found or less than 1!',
            ], 404);
        }

        $cus_orders         = array();


        $all_orders         = DB::table('route_plans')
                                ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->leftjoin('customer_has_wallets', 'customer_has_wallets.order_id', '=', 'route_plans.order_id')
                                ->select(
                                            // 'route_plans.order_id',
                                            // 'orders.ref_order_id as ref_order_id',
                                            DB::raw('CONCAT(orders.id,  "-", customers.name) as order_id'),
                                            // 'orders.delivery_charges',
                                            // 'orders.vat_charges',
                                            'customer_has_wallets.in_amount as order_amount'
                                            
                                        )
                                ->where('route_plans.status_id','!=',1)  // fetch only drop off and pick & drop off orders
                                ->where('customer_has_wallets.in_amount','>',0) // fetch only those whose payment is paid and stored in in_amoun column.
                                ->where('route_plans.rider_id',$rider_id)
                                ->whereDate('route_plans.updated_at',$this->today)
                                ->get();

        if(($all_orders->isEmpty())){
            return [];
        }

        foreach ($all_orders as $ord_key => $ord_value) {
            
            // $ord_value->order_id       = $ord_value->order_name;
            $orders                 = $ord_value;
            array_push($cus_orders,$orders);
        }
        return $cus_orders;

    }

    public function fn_payment_rides_repo($rider_id){
        $cus_orders = array();

        $orders             = DB::table('payment_rides')
                                ->leftjoin('customers', 'customers.id', '=', 'payment_rides.customer_id')
                                ->leftjoin('customer_has_wallets', 'customer_has_wallets.ride_id', '=', 'payment_rides.id')
                                ->select(
                                            // 'payment_rides.id as order_id',
                                            // DB::raw('ABS(payment_rides.bill) as order_amount'),
                                            DB::raw('CONCAT(payment_rides.id,  "-", customers.name) as order_id'),
                                            'customer_has_wallets.in_amount as order_amount'
                                        )
                                // ->where('payment_rides.status_id',6)
                                ->whereDate('payment_rides.updated_at',$this->today)
                                ->where('customer_has_wallets.in_amount','>',0) // fetch only those whose payment is paid and stored in in_amoun column.
                                ->where('payment_rides.rider_id',$rider_id)
                                ->get();

        if(($orders->isEmpty())){
            return [];
        }

        foreach ($orders as $key => $value) {
            // $ord = (array) $value; 
            array_push($cus_orders,$value);
        }

        
                                
        return $cus_orders;
    }

    // return the amount of regular orders which a rider is to take from the customers 
    public function fn_reg_orders_rep1($rider_id,$status_id = 2){
        if( (!(isset($rider_id))) ||( $rider_id < 1)){
            return response([
                'status'    => 'failed',
                'data'      => 'rider id not found or less than 1!',
            ], 404);
        }

        $cus_orders         = array();
        $tot_price          = 0;
        $ordr               = array();


        $all_orders         = DB::table('route_plans')
                                ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select(
                                            'route_plans.order_id',
                                            'orders.ref_order_id as ref_order_id',
                                            DB::raw('CONCAT(orders.id,  "-", customers.name) as order_name'),
                                            'orders.delivery_charges',
                                            'orders.vat_charges',
                                        )
                                ->where('route_plans.status_id',$status_id)
                                // ->where('route_plans.complete',0)
                                ->where('route_plans.rider_id',$rider_id)
                                ->whereDate('route_plans.updated_at',$this->today)
                                ->get();


        if(($all_orders->isEmpty())){
            return [];
        }
      
        foreach ($all_orders as $ord_key => $ord_value) {
            $orders                 = $ord_value;
            
           
            if($orders != null){
                $o_id               =  $orders->order_id;
                if((isset($orders->ref_order_id)) && (($orders->ref_order_id) != null)){
                    $o_id           =  $orders->ref_order_id;
                }
                
                $services           = DB::table('order_has_services')
                                        ->leftjoin('services', 'services.id', '=', 'order_has_services.service_id')
                                        ->select(
                                                    'services.id as service_id',
                                                )
                                        ->where('order_has_services.order_id',$o_id)
                                        ->get();
                               
                $tot_price          = 0;
                foreach ($services as $key => $value) {
                    if(!(isset($orders->ref_order_id))){     
                        $service_rate                       = $this->fn_get_addon_amount($orders->order_id,$value->service_id);
                        $addon_rate                         = $this->fn_get_service_amount($orders->order_id,$value->service_id);
                        $tot_price                         += ($service_rate + $addon_rate);
                    }else{
                        $tot_price                          = 0;
                    }
                }
                
                $orders->order_amount       = round(($tot_price + ($orders->delivery_charges) + ($orders->vat_charges)),2);
                
                $orders->order_id = $orders->order_name;
              
                // convert object to array
                    
                // dd($orders);
                // $orders                     = (array) $orders;
            
                
                // push array to custom_order array
                array_push($cus_orders,$orders);
            }
        }
        return $cus_orders;
    }


    // return the amount of payment rides orders which a rider is to take from the customers 
    public function fn_payment_rides_repo1($rider_id){
        $cus_orders = array();

        $orders             = DB::table('payment_rides')
                                ->leftjoin('customers', 'customers.id', '=', 'payment_rides.customer_id')
                                ->select(
                                            // 'payment_rides.id as order_id',
                                            DB::raw('CONCAT(payment_rides.id,  "-", customers.name) as order_id'),
                                            DB::raw('ABS(payment_rides.bill) as order_amount')
                                        )
                                // ->where('payment_rides.status_id',6)
                                ->whereDate('payment_rides.updated_at',$this->today)
                                ->where('payment_rides.rider_id',$rider_id)
                                ->get();

        if(($orders->isEmpty())){
            return [];
        }

        foreach ($orders as $key => $value) {
            // $ord = (array) $value; 
            array_push($cus_orders,$value);
        }

        
                                
        return $cus_orders;
    }


    public function fn_report($rider_id){
        $orders         = $this->fn_reg_orders_rep($rider_id);
        $rides          = $this->fn_payment_rides_repo($rider_id);
        $total_amount   = 0;

        $record         = array();
       
        foreach ($rides as $key => $value) {
            $total_amount += $value->order_amount;
        }

        foreach ($orders as $key => $value) {
            $total_amount += $value->order_amount;
        }

        $record['regular_order']       = $orders;
        $record['payment_only_rides']        = $rides;
        $record['total_amount'] = $total_amount;
        
        
        // $rcd = '{"regular_order":[{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_name":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":1000},{"order_id":6,"order_name":"6-Adila Dagra Adila Dagra Adila Dagra Adila Dagra Adila Dagra","order_amount":1020},{"order_id":9,"order_name":"9-Aliya Imran","order_amount":1900},{"order_id":7,"order_name":"7-Aelya Zaidi","order_amount":644},{"order_id":8,"order_name":"8-Alia Baig","order_amount":530}],"payment_only_rides":[{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"5-Abbas Jaffery  Abbas Jaffery Abbas Jaffery Abbas Jaffery ","order_amount":200},{"order_id":"6-Adila Dagra Adila Dagra Adila Dagra Adila Dagra Adila Dagra","order_amount":1100}],"total_amount":6394}';

        return response($record, 200);
        
    }

    public function fetch_dropoff($rider_id,$order_id,$status_id = 2){
        // BEGIN:: validating order and rider ids
            if( (!(isset($rider_id))) ||( $rider_id < 1)){
                return response([
                    'status'    => 'failed',
                    'data'      => 'rider id not found or less than 1!',
                ], 404);
            }else if((!(isset($order_id))) || ( $order_id < 1)){
                return response([
                    'status'    => 'failed',
                    'data'      => 'order id not found or less than 1!',
                ], 404);
            }
        // END:: validating order and rider ids

        $services_selected  = array();
        $tot_price          = 0;

        $orders             = DB::table('route_plans')
                                ->leftjoin('orders', 'orders.id', '=', 'route_plans.order_id')
                                ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select(
                                            'orders.id as order_id',
                                            'orders.ref_order_id as ref_order_id',
                                            'orders.customer_id as customer_id',
                                            DB::raw('CONCAT(orders.id,  "-", customers.name) as order_name'),
                                            'orders.delivery_charges',
                                            'orders.vat_charges',
                                        )
                                ->where('route_plans.order_id',$order_id)
                                ->where('route_plans.status_id',$status_id)
                                // ->where('route_plans.complete',0)
                                ->where('route_plans.rider_id',$rider_id)
                                ->first();

        if($orders != null){
            $o_id                   =  $order_id;
            $orders->vat_charges    = round(($orders->vat_charges),2);
            if((isset($orders->ref_order_id)) && (($orders->ref_order_id) != null)){
                // $order_id  = $orders->ref_order_id;
                $o_id           =  $orders->ref_order_id;
            }
            
            $services           = DB::table('order_has_services')
                                    ->leftjoin('services', 'services.id', '=', 'order_has_services.service_id')
                                    ->select(
                                                'services.id as service_id',
                                                'services.name as service_name',
                                                // 'order_has_services.qty as service_item',
                                                // 'order_has_services.weight as service_weight',
                                                DB::raw('CONCAT(order_has_services.qty," pieces") as service_item'),
                                                DB::raw('CONCAT(order_has_services.weight," KG") as service_weight'),
                                                
                                            )
                                    ->where('order_has_services.order_id',$o_id)
                                    ->get();
                           
       
            foreach ($services as $key => $value) {
                if(!(isset($orders->ref_order_id))){     
                    $service_rate                       = $this->fn_get_addon_amount($orders->order_id,$value->service_id);
                    $addon_rate                         = $this->fn_get_service_amount($orders->order_id,$value->service_id);

                    $tot_price                         += ($service_rate + $addon_rate);
                    $services[$key]->service_price      = ($service_rate + $addon_rate)." Rs.";
                }else{
                    $tot_price                                  = 0;
                    $services[$key]->service_price              =  "0 Rs.";
                }


            }
           

            $wallet             = DB::table('customer_has_wallets')
                                    ->select(
                                                        // 100 -400
                                                DB::raw('(SUM(customer_has_wallets.in_amount) - SUM(customer_has_wallets.out_amount) ) AS wallet')
                                            )
                                    ->where('customer_has_wallets.customer_id', $orders->customer_id)
                                    ->first();

            

            $orders->Services           = $services;
            // $orders->delivery_charges = (($orders->delivery_charges) + ($orders->vat_charges));
            $orders->payable_amount     = (($wallet->wallet == null) ) ? 0 : $wallet->wallet;  //600
            $orders->order_amount       = round(($tot_price + ($orders->delivery_charges) + ($orders->vat_charges)),2); // 200
            
              $orders->wallet_amount      = ($orders->payable_amount) + ($orders->order_amount); 
            // || ($wallet->wallet>0) 
            if(($orders->payable_amount) >0){
                $orders->payable_amount     = 0;
                // $orders->wallet_amount      = 0; 
            }else{
                $orders->wallet_amount      = ($orders->payable_amount) + ($orders->order_amount); 
            }
             
            $orders->polybag            = $this->count_polybags($order_id);
            $orders->polybag_items      = $this->fetch_polybags($order_id, $orders->polybag);
            
            $orders                 = (array) $orders;

            return response($orders, 200);
                
        }else{
            return response([
                'status'    => 'failed',
                'data'      => 'data not found!',
            ], 404);
        }
    }

    public function fetch_pickdrop($rider_id,$order_id){
        return $this->fetch_dropoff($rider_id,$order_id,3);
    }

    public function store_payment(Request $request){
      
        $validator = Validator::make($request->all(),
            [
                'received_amount'       => 'required|numeric|min:0',
                'order_id'              => 'required|numeric|min:0',
                'rider_id'              => 'required|numeric|min:0'
            ]
        );
        if ($validator->passes()) {
            // try{
                
                
                // $data                       = Order::select('customer_id','status_id')->find($request->order_id);
                // $data                       = Order::where('status_id2',14)->find($request->order_id);
                $data                       = Order::find($request->order_id);


                if((isset($data->status_id2)) && (($data->status_id2) == 16)){
                    return response([
                        'status'    => 'failed',
                        'error'     => "Order has been cancelled from hub!",
                    ], 404);

                }
                    
                $status_ids                 = $data->status_id;
          
                if(isset($data->customer_id)){
                    $polybags                       = $request->polybag_items;
                    // BEGIN:: update order to "complete:15"
                        $order['status_id']         = 15;
                        $order['status_id2']        = 15;
                        //  $order['status_id']         = $status_ids ;
                        $upd                        = $data->update($order);
                    // END:: update order to "complete: 15"
                        
                    $rp_data            = DB::table('route_plans')
                                            ->select('route_plans.id')
                                            ->where('route_plans.order_id',$request->order_id)
                                            ->where('route_plans.rider_id',$request->rider_id)
                                            ->where('route_plans.status_id', $status_ids)
                                            ->where('route_plans.complete', 0)
                                            ->first();
               
                    if(isset($rp_data->id)){        
                        $last_route_plan_id = $rp_data->id;

                    }else{
                        $last_route_plan_id =0;
                    }
        
                    // BEGIN:: update order to "complete:15"
                    $rp_record          = DB::table('route_plans')
                                            ->where('route_plans.order_id',$request->order_id)
                                            ->where('route_plans.rider_id',$request->rider_id)
                                            ->where('route_plans.status_id', $status_ids)
                                            ->where('route_plans.schedule', 1)
                                            ->update([
                                                        'complete'      => 1,
                                                        'is_move_to_hub'=> 1,
                                                        'time_at_loc'   => (date("H:i:s"))
                                                ]); 
                    // END:: update order to "complete: 15" 
                
                    // BEGIN:: update polybag status to scanned:1"
                        // if( ((count($polybags))> 0 )  && ( $polybags!=null)){
                        $count = 0;
                        foreach((array)$polybags as $value) {
                            if(isset($value['polybag_qr'])){
                                $count++;
                            }
                            
                        }
                        if( ( $count>0)){
                            // $polybags                   = $request->polybag_items;
                            foreach ($polybags as $key => $value) {
                                # code...

                                if( (isset($value['polybag_qr']))  && (($value['polybag_qr']) != null) ){
                                    $p_bags                 = explode('-', $value['polybag_qr']);
                                if( (isset($p_bags[0])) && (isset($p_bags[1])) ){
                                        $polybag_id             = $p_bags[0];
                                        $order_id               = $p_bags[1];
                                        $chk                    = Order_has_bag::find($polybag_id);
                                        if($chk){
                                            $rec['tag_scanned'] = 1;
                                            $chk->update($rec);
                                        }
                                    }
                                    
                                }
                                
                            }
                        }  
                    // END:: update polybag status to scanned:1"
                
                    // BEGIN:: Store order history
                        $var                     = new Order_history();
                        $var->type               = 1;
                        $var->order_id           = $request->order_id;
                        //    $val->detail             = $rec;
                        $var->created_by         = $request->rider_id;
                        $var->status_id          = 15;
                        $var->save();
                    // END:: Store order history
                    
                    // BEGIN::store wallet amount as credit/ in_amount
                        $val                        = new Customer_has_wallet();
                        $val->customer_id           = $data->customer_id;
                        $val->in_amount             = ($request->received_amount);
                        $val->order_id              = ($request->order_id);
                        $val->detail                = ("order:" .$request->order_id);
                        $val->rider_id              = $request->rider_id;
                        $val->save();
                    // END::store wallet amount as credit/ in_amount


                
                    // sending sms of payment recieved
                        $transaction_id = $val->id;
                        if(isset($transaction_id)){
                            (new NotificationController)->payment_msg($transaction_id);
                        }

                    // sending sms of last mile
                        if((isset($last_route_plan_id)) && (($last_route_plan_id) != 0)){
                            (new NotificationController)->last_mile($last_route_plan_id);
                        }

                    if($status_ids == 3){
                    
                        // create and store new order of the same customer and returns its details
                        $record = $this->store_new_order(($request->rider_id), ($data->customer_id));
                        
                    
                        $response = [
                            'status'    => "success",
                            'data'      => $record
                        ];
                        return response($response, 200);
                        
                    }else{
                        
                        $response = [
                            'status'    => "success",
                        ];
                        return response($response, 200);
                    }
                }else{
                    return response([
                        'status'    => 'failed',
                        'error'     => "customer not found!",
                    ], 404);
                }

            // }catch (Exception $e) {
            //     // echo $e;
            //     // return $e;
            //     $response = [
            //         'status'    => "error",
            //         'data'      =>  $e,
            //     ];
            //     return response($response, 200);
            // }
            
            
        
        }else{
            return response([
                'status'    => 'failed',
                'error'     => $validator->errors()->all(),
            ], 404);
        }
    }

    public function get_reasons(){
        $reason             = array();
        $data               = DB::table("reasons")->select('name')->get()->all();
        // $reason               = DB::table("reasons")->pluck("name","id")->all();

        foreach ($data as $key => $value) {
            array_push($reason, $value->name);
        }

        return response([
            'reason'     => $reason,
        ], 200);
    }

    public function check(Request $request){
        $response = [
                            'status'    => "success",
                            'data'      => "123123213",
                        ];
                        return response($response, 200);
        
    }

    public function cancel_order(Request $request){
        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:1',
                'order_id'              => 'required|numeric|min:1',
                'reason'                => 'required',
            ]
        );

        if ($validator->passes()) {    
            // BEGIN:: Update orders' column "status_id, status_id2 to 16 and "16:cancel"     
                $chk            = Order::where('id', $request->order_id)
                                    ->update([
                                                // 'status_id'     => '16',
                                                'status_id2'    => '16',
                                            ]);
                
                // $chk = true;
                // return response($request->all(), 200);
                // ret
            // END:: Update orders' column "status_id, status_id2 to 16

            if($chk){

                $mail    = app('App\Http\Controllers\MailController')->send_cancel_mail($request->order_id, $request->reason);
                if($mail == 1){
                    $msg = "Order verified and email sent successfully.";
                }else{
                    $msg = "Order verified but email not sent successfully.";
                }
                
                
                // return response($request->order_id, 200);

                // BEGIN:: Update route plan's column "complete = 0" 
                    $data       = Route_plan::where('order_id', $request->order_id)
                                    ->where('complete',0)
                                    ->where('rider_id',$request->rider_id)
                                    ->update(
                                                [
                                                    'is_canceled'        => '1',
                                                    'complete'           => '1',
                                                    'is_move_to_hub'     => '1',
                                                    'time_at_loc'        => (date("H:i:s"))
                                                    // 'status_id'    => '16',
                                                ]
                                            );
                // END:: Update route plan's column "complete = 0" 

                // BEGIN:: json encode order history  
                    $record['order_id']      = $request->order_id;
                    $record['rider_id']      = $request->rider_id;
                    $record['reason']        = $request->reason;
                    $rec                     = json_encode($record); 
                // END:: json encode order history 
                
                // BEGIN:: Store order history
                    $val                     = new Order_history();
                    $val->type               = 1;
                    $val->order_id           = $request->order_id;
                    $val->detail             = $rec;
                    $val->created_by         = $request->rider_id;
                    $val->status_id          = 16;
                    $val->save();
                // END:: Store order history

                if($record['reason'] == "Customer was not at home"){

                    // Rider Cancellation (Pickup) – (Trigger when Rider cancels pickup with No show option): 
                    (new NotificationController)->rider_cancel_pick($request->order_id);
                }else if($record['reason'] == "Pickup with too expensive"){
                    // Rider Cancellation (Pickup) – (Trigger when Rider cancels pickup with too expensive option):
                    (new NotificationController)->rider_cancel_pickup($request->order_id);
                }else{
                    // Rider Cancellation (Pickup) – (Trigger when Rider cancels pickup with other option):
                    (new NotificationController)->rider_cancel_other($request->order_id);
                }
               
                $response = [
                    'status'    => "success"
                ];
                return response($response, 200);
            }
        }else{
            return response([
                'status'    => 'failed',
                'error'     => $validator->errors()->all(),
            ], 404);
        }
    }

    function is_sunday($date) {
        $weekDay = date('w', strtotime($date));
    
        return ($weekDay == 0 );
    }

    function is_holiday($holidays,$date){
        if(!(empty($holidays))){
            foreach($holidays as $key => $value){
                if(($value->holiday_date) == $date){
                    return true;
                }
            }
        }
        return false;
    }

    public function get_delivery_date($pickup_date){
       
        $holidays           = DB::table('holidays')
                                ->select('holiday_date')
                                ->get()
                                ->all();
  
        $delivery_date      = $pickup_date;
        
        for($i=0; $i<4; $i++){
            get_cus_date:
            $delivery_date  = date('Y-m-d', strtotime($delivery_date. ' + 1 days'));
            // echo $delivery_date."<br>";
            $is_sunday      = $this->is_sunday($delivery_date);
            $is_holiday     = $this->is_holiday($holidays,$delivery_date);

            if($is_sunday  || $is_holiday ){
                goto get_cus_date;
                // $delivery_date  = date('Y-m-d', strtotime($delivery_date. ' + 1 days'));
            }
        }
        return $delivery_date;
    }
    
    public function store_new_order($rider_id, $customer_id){
        // BEGIN :: fetch last inserted order of the given customer id 
        if( (!(isset($rider_id))) || (!(isset($customer_id))) ){
            return response([
                'status'    => 'failed',
                'error'     => "rider id or customer id not found",
            ], 404);
        }
        $order              = DB::table('orders')
                                ->select(
                                            'orders.customer_id',
                                            'orders.order_note',
                                            'orders.area_id',
                                            'orders.hub_id',
                                            // 'orders.pickup_date',
                                            'orders.pickup_address_id',
                                            'orders.pickup_address',
                                            'orders.pickup_timeslot_id',
                                            'orders.pickup_timeslot',
                                            'orders.pickup_rider_id',
                                            'orders.pickup_rider',
                                            'orders.created_by',
                                        )
                                ->where('orders.customer_id', $customer_id)
                                ->latest('created_at')
                                ->first();

        // Get rider name
        $rdr_name       = null;
        $rdr            = DB::table('riders')
                                ->where('riders.id', $rider_id)
                                ->select(
                                            'riders.name as name'
                                        )
                                ->first();
       

        if(isset($rdr->name)){
            $rdr_name   = $rdr->name;
        }

                                
        // END :: fetch last inserted order of the given customer id 
        if(isset($order->customer_id)){
            // BEGIN:: Setting and Storing new order of the given customer id 
                $val                        = new Order();
                $val->customer_id           = $order->customer_id;
                $val->order_note            = $order->order_note;
                $val->area_id               = $order->area_id;
                $val->hub_id                = $order->hub_id;
                $val->pickup_date           = $this->today;
                $val->delivery_date         = $this->get_delivery_date($this->today);

                $val->pickup_address_id     = $order->pickup_address_id;
                $val->pickup_address        = $order->pickup_address;

                $val->pickup_timeslot_id    = $order->pickup_timeslot_id;
                $val->pickup_timeslot       = $order->pickup_timeslot;
                
                $val->pickup_rider_id       = $rider_id;
                $val->pickup_rider          = $rdr_name;
                $val->created_by            = $order->created_by;
                $val->status_id             = 1;
                $val->status_id2            = 1;
                $val->save();
            // BEGIN:: Setting and Storing new order of the given customer id 

            if(isset($val->id)){
               
            
            
                $order_id  = $val->id;
                
                // BEGIN:: Store order history of new  pickup
                    $val                     = new Order_history();
                    $val->type               = 1;
                    $val->order_id           = $order_id;
                    //    $val->detail             = $rec;
                    $val->created_by         = $rider_id;
                    $val->status_id          = 1;
                    $val->save();
                // END:: Store order history of new  pickup
                
                
                // fetch and return new pickup and services details
                return $this->fetch_new_pickup($rider_id,$order_id);
            }
        }else{
            return response([
                'status'    => 'failed',
                'data'      => 'Data Not Found !',
            ], 404);
        }

        
    }

    public function fetch_rides($rider_id){
        $orders             = DB::table('payment_rides')
                                ->leftjoin('time_slots', 'time_slots.id', '=', 'payment_rides.timeslot_id')
                                ->leftjoin('customers', 'customers.id', '=', 'payment_rides.customer_id')
                                ->leftjoin('customer_has_addresses', 'customer_has_addresses.id', '=', 'payment_rides.address_id')
                                ->select(
                                            'payment_rides.id as order_id',
                                            'customers.id as customer_id',
                                            'customers.name as customer_name',
                                            'customer_has_addresses.address as address',
                                            'customers.permanent_note as permenantNote',
                                            'customers.contact_no as buttonCall',
                                            DB::raw('"Payment" as buttonService'),
                                            // DB::raw('(ABS(payment_rides.bill)-payment_rides.bill_paid) as cash'),
                                            DB::raw('(CASE 
                                                        WHEN ((ABS(payment_rides.bill)-payment_rides.bill_paid) < 0) THEN 0 
                                                        ELSE (ABS(payment_rides.bill)-payment_rides.bill_paid)
                                                        END) AS cash'
                                                    ),
                                            DB::raw('CONCAT(time_slots.start_time,  "  -  ", time_slots.end_time) as rideTime'),
                                            DB::raw('CONCAT(payment_rides.id,  "-", customers.name) as title'),
                                            DB::raw('CONCAT(customer_has_addresses.latitude,  "-", customer_has_addresses.longitude) as buttonMap'),
                                        )
                                ->where('payment_rides.status_id',6)
                                ->whereDate('payment_rides.created_at',$this->today)
                                ->where('payment_rides.rider_id',$rider_id)
                                ->get()->all();
        return $orders;
    }

    public function fetch_pay_rides($rider_id){
        $orders     = $this->fetch_rides($rider_id);
        return response($orders, 200);
    }

    public function store_pay_rides(Request $request){
        
        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:1',
                'order_id'              => 'required|numeric|min:1',
                'recievedamount'        => 'required|numeric|min:0',
            ]
        );

        if ($validator->passes()) {    
           
            $data               = Payment_ride::select('customer_id')->find($request->order_id);
            if(isset($data->customer_id)){

                 // BEGIN:: Update Payment_rides' column "status_id to 16 and "16:cancel"     
                 $chk            = Payment_ride::where('id', $request->order_id)
                                    ->update([
                                                'status_id'     => '15',
                                                'time_at_loc'   => (date("H:i:s"))
                                            ]);
                // END:: Update Payment_rides' column "status_id to 16

                // BEGIN::  Storing the Customer_has_wallet
                    $val                        = new Customer_has_wallet();
                    $val->customer_id           = $data->customer_id;
                    $val->in_amount             = $request->recievedamount;
                    $val->ride_id               = $request->order_id;
                    $val->rider_id              = $request->rider_id;
                    $val->detail                = "Ride id: ".$request->order_id ;
                    $val->save();
                // END::    Storing the Customer_has_wallet

                // BEGIN::  Storing the payment_ride_histories
                    $history                       = Payment_ride_history::select('id')
                                                    ->where('payment_ride_id',$request->order_id)
                                                    ->where('status_id',15)
                                                    ->first();
                                             
                    if(!(isset($history->id))){
                        $rec                        = new Payment_ride_history();
                        $rec->payment_ride_id       = $request->order_id;
                        $rec->status_id             = 15; 
                        $rec->created_by            = $request->rider_id;
                        $rec->save();
                    }
                // END::    Storing the payment_ride_histories


                // fetch remaining rides
                $record = $this->fetch_rides($request->rider_id);

                return  response([
                    'status'    => "success",
                    'data'      => $record 
                ],200);
            }

        }else{
            return response([
                'status'    => 'failed',
                'error'     => $validator->errors()->all(),
            ], 404);
        }
    }
}


