<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Models\Rider;
use App\Models\Order;
use App\Models\Route_plan;
use App\Models\Rider_history;
use Illuminate\Http\Request;

class MeterController extends Controller
{
    public $today;
    function __construct()
    {
        $this->today        = date('Y-m-d');
    }

    public function day_status($rider_id){
        $startDay           = false;
        $endDay             = false;
        $data               = Rider_history::select(
                                                        'rider_histories.start_reading',
                                                        'rider_histories.end_reading'
                                                    )
                                    ->where('rider_histories.rider_id', $rider_id)
                                    ->whereDate('rider_histories.plan_date', $this->today)
                                    ->first();

        if(isset($data->start_reading)){
            $startDay       = true;
        }

        if(isset($data->end_reading)){
            $endDay         = true;
        }


        $response = [
            'status'        => "success",
            'startDay'      => $startDay,
            'endDay'        => $endDay,
        ];
        return response($response, 200);
    }

    public function store_reading(Request $request){

        // dd("asdfasdf");
        $validator = Validator::make($request->all(),
            [
                'rider_id'              => 'required|numeric|min:0',
                'type'                  => 'required|numeric|min:0',
                'reading'               => 'required|numeric|min:0',
                'image'                 => 'required|image|mimes:jpeg,png,jpg,gif|max:512'
            ],
            [
                'rider_id'              => 'Please enter rider id',
            ]
        );

        if ($validator->passes()) {

            $image          = $request->file('image');
            $new_name       = rand().'.'.$image->getClientOriginalExtension();
                                $image->move(public_path("uploads/meters"),$new_name);

            $input          = $request->all();

            if(($request->type) == 0 ){  // 0: start day
                
                $input['start_reading'] = ($request->reading);
                $input['start_img']     = $new_name;
                $input['plan_date']     = $this->today;
                $history                = Rider_history::where('rider_histories.rider_id', $request->rider_id)
                                            ->whereDate('rider_histories.plan_date', $this->today)
                                            ->first();
                if($history != null){
                    $response = [
                        'status'        => "error",
                        'data'          => "You have already started day"
                    ];
                    return response($response, 404);
                    // $history->delete();
                }
                $data                   = Rider_history::create($input);

            }else{                      // 0: end day

                $payment_rides          = DB::table('payment_rides')
                                            ->where('payment_rides.status_id',6)
                                            ->where('payment_rides.rider_id',$request->rider_id)
                                            ->get();

                $orders                 = DB::table('route_plans')
                                            ->where('route_plans.complete',0)
                                            ->whereNotNull('route_plans.route')
                                            ->whereDate('route_plans.updated_at',$this->today)
                                            ->where('route_plans.rider_id',$request->rider_id)
                                            ->get();

                $reg_orders             = DB::table('orders')
                                            ->where('orders.status_id',1)
                                            ->where('orders.status_id2',1)
                                            ->whereNull('orders.updated_by')
                                            ->whereDate('orders.created_at',$this->today)
                                            ->where('orders.pickup_rider_id',$request->rider_id)
                                            ->get();
                                            


                $msg = '';
                if((!($payment_rides->isEmpty()))){
                    $msg = "Payment ride(s) are pending!!!!";
                }elseif(!($reg_orders->isEmpty()))  {
                    $msg = "Recently Added Order(s) are pending!!!!";
                }elseif(!($orders->isEmpty()))  {
                    $msg = "Order(s) are pending!!!!";
                }

                if($msg != ''){
                    $response = [
                        'status'    => "pending",
                        'data'     => $msg
                    ];
                    return response($response, 201);
                }
                
                $input['end_reading']   = ($request->reading);
                $input['end_img']       = $new_name;

                $history                = Rider_history::where('rider_histories.rider_id', $request->rider_id)
                                            ->whereDate('rider_histories.plan_date', $this->today)
                                            ->first();

                if($history != null){
                    // $history->delete();
                    $data                   = $history->update($input);
                }

                
            }

            // if($data){
                $response = [
                    'success'            => "true",
                ];
                return response($response, 200);
            // }
        }

        $response = [
            'status'    => "failed",
            'error'     => $validator->errors()->all(),
        ];
        return response($response, 404);
    }


     
}


