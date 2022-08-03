<?php
namespace App\Http\Controllers\API;

use DB;
use Response;
use Validator;
use Exception;
use App\Models\City;
use App\Models\People;
use App\Models\Rating;
use App\Models\Reason;
use App\Models\Booking;
use App\Models\History;
use App\Models\Province;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\People_detail;
use App\Models\People_rating;
use App\Models\People_vehicle;
use App\Http\Requests\MainRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TwilioSMSController;
use App\Http\Controllers\NotificationController;

class MainController extends Controller
{
    function login(MainRequest $request)
    {
        $record             = People::where('contact_no', $request->contact_no)->first();
        $record_details     = People_detail::where('people_id', $record->id)->first();
        // is user exist
        if(empty($record)){
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'Couldn\'t find your Account.',
                                    "data"      => []
                                ], 404);
        }

        // checking password
        if(!(Hash::check($request->password, $record->password))) {
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Invalid password',
                "data"      => []
            ], 404);

        }

        // otp will be sent to non-verified user.
        if($record->verified != 1) {
       
            $input['otp']        = rand(1000, 9999);
            $input['temp_code']  = rand(1000000000, 9999999999);
                                    $record->update($input);
            // appending +92 with contact_no
            $cno = $this->set_contact_no($request->contact_no);

            // send sms using Twilio
            // (new TwilioSMSController)->index($cno, $input['otp']);
            (new NotificationController)->send_otp($cno, $input['otp']);
            
            return Response::json([
                                    'status'        => "success",
                                    'msg'           => "OTP sent",
                                    'data'          =>  [
                                                            'temp_code' =>$input['temp_code']
                                                        ]
                                ], 200);

        }
       
        // if above all condition 
        // delete all previous tokens of this ID
        // $record->tokens()
        //         ->where('tokenable_id', $record->id)
        //         ->where('name', 'people-token')
        //         ->delete();

        // create new token for this ID
        $token      = $record->createToken('people-token')->plainTextToken;
        $type       = (((($record->type) =="Captain") || (($record->type) ==1))? "Captain" : "Passenger" );
        $role       = (((($record->role) =="Captain") || (($record->role) ==1))? "Captain" : "Passenger" );


        $request->people_id =    $record->id;

        $records    = (($record->role  == "Captain") || ($record->role == 1) ) ? ($this->fetch_schedules($request,true)) :($this->fetch_bookings($request,true));

        $bool       = (!empty($record_details)) ? true : false;
        $pth        = ((isset($record_details->profile_pic))) ? ( "public/uploads/licenses/".($record_details->profile_pic)) : ("public/uploads/no_image.png");
        $people_id  = (isset($record->id)) ? ($record->id) : "";
        $fname      = (isset($record->fname)) ? ($record->fname) : "";
        $email      = (isset($record_details->email)) ? ($record_details->email) : "";

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Logged in successfully",
                                'data'          =>  [
                                                        'token'                 => $token,
                                                        'fname'                 => $fname,
                                                        'email'                 => $email ,
                                                        'profile_pic'           => $pth,
                                                        'people_id'             => $people_id,
                                                        'type'                  => $type,
                                                        'role'                  => $role, // toggle role in app
                                                        'records'               => $records,
                                                        'registration_complete' => $bool
                                                    ]
                               
                            ], 200);

    }

    public function verify_otp(MainRequest $request)
    {
        $record     = People::where('otp', $request->otp)
                            ->where('temp_code', $request->temp_code)
                            ->whereNull('forgot')
                            ->first();
                            
        if ( (empty($record))  || $record->otp == null  ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Invalid OTP',
                "data"      => []
            ], 404);
        }
        
        $input               = array();
        $input['otp']        = null;
        $input['verified']   = 1;
        $input['temp_code']  = null;

        $record->update($input);

        return Response::json([
                            'status'        => "success",
                            'msg'           => "OTP verified",
                            "data"          => []
                        ], 200);

    }

    // send_reset_otp
    public function forgot(MainRequest $request)
    {
        $record             = People::where('contact_no', $request->contact_no)->first();

        if ( empty($record)){
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'Invalid contact number',
                                    "data"      => []
                                ], 404);
        }

       // otp will be sent to non-verified user.
       $input['temp_code']  = rand(1000000000, 9999999999);
       $input['otp']        = rand(1000, 9999);
       $input['forgot']     = 1;
                              $record->update($input);

       // appending +92 with contact_no
       $cno = $this->set_contact_no($request->contact_no);

       // send sms using Twilio
       // (new TwilioSMSController)->index($cno, $input['otp']);
       (new NotificationController)->send_otp($cno, $input['otp']);
       
       return Response::json([
                               'status'        => "success",
                               'msg'           => "OTP sent",
                               "data"          => [
                                                    'temp_code' =>  $input['temp_code'],
                                                    'name'      => "forgot"
                                                ]
                            ], 200);
    }

    // store_reset_otp
    public function forgot_otp(MainRequest $request)
    {
        $record     = People::where('otp', $request->otp)
                            ->where('temp_code', $request->temp_code)
                            ->whereNotNull('forgot')
                            ->first();

        if ( empty($record)){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Invalid OTP',
                "data"      => []
            ], 404);
        }

        $input               = array();
        $input['otp']        = null;
        $input['verified']   = 1;
        $input['forgot']     = null;
        $input['temp_code']  = rand(1000000000, 9999999999);

        $record->update($input);

        return Response::json([
                            'status'        => "success",
                            'msg'           => "Forgot OTP verified",
                            "data"          => [
                                                'temp_code' =>  $input['temp_code'],
                                                'name'      => "forgot_otp"
                                            ]
                        ], 200);

    }

    public function update_password(MainRequest $request)
    {
        $record     = People::where('temp_code', $request->temp_code)->first();

        if ( empty($record)){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Couldn\'t find your Account.',
                "data"      => []
            ], 404);
        }

        $input               = array();
        $input['otp']        = null;
        $input['verified']   = 1;
        $input['password']   = Hash::make($request->password);
        $input['temp_code']  = null;

        $record->update($input);

        return Response::json([
                            'status'        => "success",
                            'msg'           => "Password reset",
                            "data"          => []
                        ], 200);

    }

    public function set_contact_no($cno){
        if($cno[0] == "0"){
            $cno = "+92".(ltrim($cno, "0"));
        }
        return $cno;
    }

    public function register(MainRequest $request)
    {
        $otp                 = rand(1000, 9999);
        $temp_code           = rand(100000000, 999999999);
        $record              = People::where('contact_no', $request->contact_no)->first();

        if ( empty($record)){
            $input               = $request->all();
            $input['otp']        = $otp;
            $input['temp_code']  = $temp_code;
            $input['fname']      = ucwords($input['fname']);
            $input['cnic']       = $input['cnic'];
            $input['password']   = Hash::make($input['password']);
            $record              = People::create($input);
        }else{
            $input['temp_code']  = $temp_code;
            $input['otp']        = $otp;
            $record->update($input);
        }

        // appending +92 with contact_no
        $cno = $this->set_contact_no($request->contact_no);
        
        // send sms using Twilio
        // (new TwilioSMSController)->index($cno, $otp);
        (new NotificationController)->send_otp($cno, $otp);
        
        return Response::json([
                                'status'        => "success",
                                'msg'           => "OTP sent",
                                'data'          =>  [
                                                        'temp_code' => $temp_code
                                                    ]
                            ], 200);
                            
       
    }

    public function append_rating($schedules){
       
        foreach ($schedules as $key => $schedule) {
            $rating                     = People_rating::where('people_ratings.schedule_id',$schedule->schedule_id)->avg('people_ratings.rating');
            $schedules[$key]->rating    = round($rating);
        }

        return $schedules;
    }

    public function cancel_booking(MainRequest $request)
    {

        $record             = Booking::where('bookings.active',1)
                                ->where('bookings.passenger_id',$request->people_id)
                                ->where('bookings.id',$request->booking_id)
                                ->where('bookings.status_id','<=',3)
                                ->first();
                                
                        
        // is booking exist
        if(empty($record)){
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'No booking found.',
                                    "data"      => []
                                ], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record) {

                // BEGIN::update schedule to cancel
                    $input                      = $request->all();
                    $input['status_id']         = env('STATUS_CANCEL_ID'); 
                                                  $record->update($input);
                // END::update schedule to cancel

                $this->store_history($request->people_id,0,$record->schedule_id,$request->booking_id,null,env('STATUS_CANCEL_ID'));
            });
            if(is_null($exception)) {
                return Response::json([
                    'status'        => "success",
                    'msg'           => "Booking cancelled successfully",
                    "data"          => []
                ], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong.',
                "data"      => []
            ], 404);
        }
    }

    public function cancel_schedule(MainRequest $request)
    {
        $record             = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.id',$request->schedule_id)
                                ->where('schedules.status_id','<=',3)
                                ->first();
                                
        // is schedule exist
        if(empty($record)){
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'No schedule found.',
                                    "data"      => []
                                ], 404);
        }

        try {
            $exception = DB::transaction(function()  use ($request,$record) {

                // BEGIN::update schedule to cancel
                    $input                      = $request->all();
                    $input['status_id']         = env('STATUS_CANCEL_ID'); 
                                                  $record->update($input);
                // END::update schedule to cancel

                // BEGIN::store cancel schedule history
                    $this->store_history($request->people_id,1,$record->schedule_id,null,null,env('STATUS_CANCEL_ID'));
                // END::store cancel schedule history

                
                // BEGIN::fetch all bookings against this schedule id
                    $bookings           = Booking::where('bookings.active',1)
                                            ->where('bookings.schedule_id',$request->schedule_id)
                                            ->where('bookings.status_id','<=',3)
                                            ->get();
                // END::fetch all bookings against this schedule id
               

                // BEGIN::cancel all bookings against this schedule id
                    $upd                = Booking::where('bookings.active',1)
                                            ->where('bookings.schedule_id',$request->schedule_id)
                                            ->where('bookings.status_id','<=',3)
                                            ->update(['status_id' =>  env('STATUS_CANCEL_ID') ]);
                // END::cancel all bookings against this schedule id


                // BEGIN::store cancel history of booking because schedule is cancelled
                    foreach ($bookings as $key => $booking) {
                        $this->store_history($booking->passenger_id,0,$booking->schedule_id,$request->id,"Schedule cancelled",env('STATUS_CANCEL_ID'));
                    }
                // END::store cancel history of booking because schedule is cancelled

            });
            if(is_null($exception)) {
                return Response::json([
                    'status'        => "success",
                    'msg'           => "Schedule cancelled successfully",
                    "data"          => []
                ], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong.',
                "data"      => []
            ], 404);
        }
    }

    public function toggle_role(MainRequest $request)
    {
        $msg                 = "";
        $data                = [];
        $code                = 404;
        $status              = "failed";

        $record              = People::where('id', $request->people_id)->first();


        // dd($record->type);
        if ( empty($record) ){
            $msg              = "Couldn't find your Account";

        }else if(($record->type  != "Captain") && ((ucfirst($request->role)) == "Captain") ){
            $msg              = "Passenger can't be toggled to captain";

        }else if(( (ucfirst(strtolower($request->role))) != "Passenger")  && ((ucfirst(strtolower($request->role))) != "Captain")){
            $msg              = "Invalid toggle value!";

        }else{
            // BEGIN::update role of people from passenger to captain or vice versa
                $rec['role'] = ((((ucfirst(strtolower($request->role)))) == "Passenger") ? 0 : 1 ); // 1: captain and 0: passenger
                $record->update($rec);
            // END::update role of people from passenger to captain or vice versa


            if( $rec['role'] == 1 ){
                $records    = $this->fetch_schedules($request,true);
            }else{
                $records    = $this->fetch_bookings($request,true);
            }

            $msg                 = "Role toggled successfully";
            $status              = "success";
            $code                = 200;
            $data                = ['records' => $records];
           
        }

        return Response::json([
            'status'    => $status,
            'msg'       => $msg,
            "data"      => $data
        ], $code);

    }
    
    public function store_details(MainRequest $request)
    {
        $record              = People::where('cnic', $request->cnic)->first();
        $detail              = People_detail::where('people_id', $record->id)->first();
        $vehicle             = People_vehicle::where('people_id', $record->id)->first();

        if ( empty($record) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'CNIC does not match',
                "data"      => []
            ], 404);
        }

        if (!( empty($detail)) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Details are already added',
                "data"      => []
            ], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record,$detail,$vehicle) {

                // BEGIN::update type of people from passenger to captain to create the ride
                    $rec['type']         = 1; // 1: captain and 0: passenger
                    $rec['role']         = 1; // 1: captain and 0: passenger
                    $record->update($rec);
                // END::update type of people from passenger to captain to create the ride

                // BEGIN::store detail in people_details table
                    $input                = $request->all();
                    $input['people_id']   = $record->id;
                    $rec                  = People_detail::create($input);
                // END::store detail in people_details table

                if( (array_key_exists("tax_pic",$input)) && (!empty($input['tax_pic']))  ){

                    // delete the previous image
                    if(isset($vehicle->tax_pic)){
                        if (file_exists( public_path('uploads/licenses/'.$vehicle->tax_pic) )){
                            unlink(public_path('uploads/licenses/'.$vehicle->tax_pic));
                        }
                    }

                    // move the image to the licenses directory
                    $image                  = $request->file('tax_pic');
                    $input['tax_pic']       = rand().'.'.$image->getClientOriginalExtension();
                                            $image->move(public_path("uploads/licenses"),$input['tax_pic']);
                }

                // BEGIN::store detail in people_details table
                    $rec                = People_vehicle::create($input);
                // END::store detail in people_details table

            });

                
            if(is_null($exception)) {

                $vehicle             = People_vehicle::where('people_id', $record->id)->first();
                $vehicle_id          = (isset($vehicle->id))? ($vehicle->id) :null ; 

                return Response::json([
                                        'status'        => "success",
                                        'msg'           => "Details added successfully",
                                        'data'          =>  [
                                                                'fname'         => $record->fname,
                                                                'people_id'     => $record->id,
                                                                'type'          => "Captain",
                                                                'vehicle_id'    => $vehicle_id
                                                            ]
                                    ], 200);
            }else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong',
                "data"      => []
            ], 404);
        }
    }

    public function store_schedule(MainRequest $request)
    {
        $record                 = People::where('id', $request->people_id)
                                    ->where('type', 1) // 1: captain
                                    ->first();

        $schedule               = Schedule::where('captain_id', $request->people_id)
                                    ->where('status_id','!=', env('STATUS_CANCEL_ID')) // cancelled
                                    ->where('schedule_time', $request->schedule_time)
                                    ->where('schedule_date', $request->schedule_date)
                                    ->first();

        
        if ( empty($record) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Only captain can create a ride, please add detail first',
                "data"      => []
            ], 404);
        }

        if (!( empty($schedule)) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Schedule is already added',
                "data"      => []
            ], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request, $record) {

                // BEGIN::store detail in people_details table
                    $schedule                = $request->all();
                    $schedule['captain_id']  = $record->id;
                    $schedule['status_id']   = 1;  // 1: Scheduled
                    $schedule                = Schedule::create($schedule);
                // END::store detail in people_details table

                $this->store_history($record->id,1,$schedule->id,null,null,1);
               

            });
            if(is_null($exception)) {
                return Response::json([
                    'status'        => "success",
                    'msg'           => "Schedule added successfully",
                    "data"          => []
                ], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            // dd($e);
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong',
                "data"      => []
            ], 404);
        }
    }

    public function store_history($people_id,$type,$schedule_id,$booking_id,$detail=null,$status_id){

        // BEGIN::store history
            $req                = array();
            $req['people_id']   = $people_id;
            $req['type']        = $type;
            $req['schedule_id'] = $schedule_id;
            $req['booking_id']  = $booking_id;
            $req['detail']      = $detail;
            $req['status_id']   = $status_id;
            $req                = History::create($req);
        // END::store history

        return true;
    }

    public function store_booking(MainRequest $request)
    {
        $schedule           = Schedule::where('schedules.id', $request->schedule_id)
                                ->leftjoin('statuses', 'statuses.id', '=', 'schedules.status_id')                                
                                ->select(
                                        'schedules.id',
                                        'schedules.status_id',
                                        'schedules.vacant_seat',
                                        'statuses.name as status_name',
                                    )
                                ->first();

                                       
        if ( empty($schedule) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Invalid schedule id',
                "data"      => []
            ], 404);
        }

        if((isset($schedule->status_id))  && (($schedule->status_id) > 2)){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'You cannot schedule because captain '.($schedule->status_name),
                "data"      => []
            ], 404);
        }

        $booking            = Booking::where('schedule_id', $schedule->id)
                                ->where('status_id','!=', env('STATUS_CANCEL_ID')) //  cancelled
                                ->sum('book_seat');

        if ( (isset($schedule->vacant_seat)) && ( (($booking) >= ($schedule->vacant_seat)) || (($request->book_seat) > ($schedule->vacant_seat))  || ( ( ($request->book_seat) + ($booking) ) > ($schedule->vacant_seat) ) ) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'No vacant seat available',
                "data"      => []
            ], 404);
        }

        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request) {

                // BEGIN::store detail in people_details table
                    $booking                    = $request->all();
                    $booking['passenger_id']    = $request->people_id;
                    $booking['status_id']       = 1;  // 1: Scheduled
                    $booking                    = Booking::create($booking);
                // END::store detail in people_details table

                $this->store_history($request->people_id,0,$request->schedule_id,$booking->id,null,1);
            });
            if(is_null($exception)) {
                return Response::json([
                    'status'        => "success",
                    'msg'           => "Booking added successfully",
                    "data"          => []
                ], 200);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            // dd($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong.',
                "data"      => []
            ], 404);
        }
    }

    public function count_schedules($captain_id){

        return  Schedule::where('schedules.active',1)
                        ->where('schedules.captain_id',$captain_id)
                        ->where('schedules.status_id','<=',3)
                        ->count();
    }
    
    public function count_bookings($schedule_id){

        $seats      = Booking::where('bookings.schedule_id',$schedule_id)
                            ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                            ->sum('book_seat');
                            
        return    $seats;
    }

    public function fetch_schedule_of_booking($schedule_id){
        
        $schedule           = Schedule::where('schedules.active',1)
                                ->where('schedules.id',$schedule_id)
                                // ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'schedules.captain_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                            'people.fname as cap_name',
                                            'people_details.profile_pic',
                                            'schedules.fare',
                                            'schedules.vacant_seat',
                                            DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                            DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                        )
                                ->first();
        return  $schedule;

    }

    public function fetch_bookings(MainRequest $request, $inner_call = FALSE)
    {
        $bookings           = Booking::where('bookings.active',1)
                                ->where('bookings.passenger_id',$request->people_id)
                                ->where('bookings.status_id','<=',3)
                                ->select(
                                            'bookings.id as booking_id',
                                            'bookings.schedule_id as schedule_id',
                                        )
                                ->get();
                                
        foreach ($bookings as $key => $booking) {

            $rating                         = People_rating::where('people_ratings.schedule_id',$booking->schedule_id)
                                                ->avg('people_ratings.rating');

            $seats                          = Booking::where('bookings.schedule_id',$booking->schedule_id)
                                                ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                                                ->sum('book_seat');

            $bookings[$key]->vacant_seat    = (($booking->vacant_seat) -  $seats);
            $bookings[$key]->rating         = round($rating);

            
            $schdl                          = $this->fetch_schedule_of_booking($bookings[$key]->schedule_id );

            $bookings[$key]->fare           = (isset($schdl->fare)) ? $schdl->fare : 0;
            $bookings[$key]->vacant_seat    = (isset($schdl->vacant_seat)) ? $schdl->vacant_seat : 0;
            $bookings[$key]->pickup_address = (isset($schdl->pickup_address)) ? $schdl->pickup_address : null;
            $bookings[$key]->dropoff_address= (isset($schdl->dropoff_address)) ? $schdl->dropoff_address : null;

            $bookings[$key]->cap_name       = (isset($schdl->cap_name)) ? $schdl->cap_name : null;
            $bookings[$key]->profile_pic    = (isset( $schdl->profile_pic)) ? ("public/uploads/peoples/".($schdl->profile_pic)) :( "public/uploads/no_image.png");

        }
     
        if($inner_call){
            return [
                        'bookings' => $bookings
                ];
        }

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Bookings fetched for passenger successfully",
                                'data'          => [
                                                        'bookings' => $bookings
                                                ]
                            ], 200);
    }

    public function fetch_schedules(MainRequest $request, $inner_call = FALSE)
    {
        $record              = People::where('id', $request->people_id)->first();

        if(((ucfirst(strtolower($request->role)))) == "Captain"){
            $rec['role'] = 1;
            $record->update($rec);
        }

        $schedules          = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'schedules.captain_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                            'schedules.id as schedule_id',
                                            'schedules.fare',
                                            'schedules.vacant_seat',
                                            
                                            'people.fname as cap_name',

                                            'people_vehicles.make',
                                            'people_vehicles.modal',
                                            'people_details.profile_pic',
                                            DB::raw('(CASE 
                                                WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                                ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                                END) AS profile_pic'
                                            ),

                                            DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                            DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                        )
                                ->get();

        $tot_schedules      = $this->count_schedules($request->people_id);


        foreach ($schedules as $key => $schedule) {
            $rating     = People_rating::where('people_ratings.schedule_id',$schedule->schedule_id)->avg('people_ratings.rating');
            $seats      = Booking::where('bookings.schedule_id',$schedule->schedule_id)
                            ->where('bookings.status_id','!=',env('STATUS_CANCEL_ID'))  //cancelled
                            ->sum('book_seat');

            // $schedules[$key]->profile_pic   = (isset( $schedule->profile_pic)) ? ("public/uploads/peoples/".($schedule->profile_pic)) :( "public/uploads/no_image.png");

            $schedules[$key]->vacant_seat   = (($schedule->vacant_seat) -  $seats);
            $schedules[$key]->rating        = round($rating);
        }

        if($inner_call){
            return [
                        'schedules'     => $schedules,
                        'tot_schedules' => $tot_schedules,
                    ];
        }

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Schedules fetched for captain successfully",
                                'data'          => [
                                                        'schedules'     => $schedules,
                                                        'tot_schedules' => $tot_schedules,
                                                ]
                            ], 200);
    }
    
    public function fetch_schedule_by_people(MainRequest $request)
    {
        $schedules  = Schedule::where('schedules.active',1)
                                ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        $schedules          = $this->append_rating($schedules);
        $tot_schedules      = $this->count_schedules($request->people_id);

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Schedules fetched by people successfully",
                                'data'          => [
                                                        'schedules' => $schedules,
                                                        'tot_schedules' => $tot_schedules
                                                ]
                            ], 200);
    }

    public function fetch_schedule_by_city(MainRequest $request)
    {
        $schedules  = Schedule::where('schedules.active',1)
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        $schedules          = $this->append_rating($schedules);
        $tot_schedules      = $this->count_schedules($request->people_id);

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Schedules fetched by city successfully",
                                'data'          => [
                                                        'schedules'     => $schedules,
                                                        'tot_schedules' => $tot_schedules,
                                                ]
                            ], 200);
    }

    public function fetch_schedule_by_date(MainRequest $request)
    {
        $schedules  = Schedule::where('schedules.active',1)
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->where('schedules.schedule_date',$request->schedule_date)
                                ->where('schedules.status_id','<=',3)
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.captain_id',
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        $schedules          = $this->append_rating($schedules);
        $tot_schedules      = $this->count_schedules($request->people_id);

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Schedules fetched by date successfully",
                                'data'          => [
                                                        'schedules' => $schedules,
                                                        'tot_schedules' => $tot_schedules
                                                ]
                            ], 200);
    }

    public function fetch_schedule_by_time(MainRequest $request)
    {
        
        $end_time   = \Carbon\Carbon::createFromFormat('H', $request->end_time);
        $start_time = \Carbon\Carbon::createFromFormat('H', $request->start_time);
        $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_date);
        $end_date   = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_date);

        $schedules  = Schedule::where('schedules.active',1)
                                // ->where('schedules.captain_id',$request->people_id)
                                ->where('schedules.pickup_city_id',$request->pickup_city_id)
                                ->where('schedules.dropoff_city_id',$request->dropoff_city_id)
                                ->whereBetween('schedules.schedule_date',[$start_date,$end_date])
                                ->whereBetween('schedules.schedule_time',[$start_time,$end_time])
                                ->where('schedules.status_id','<=',3) 
                                ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                                ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                ->leftjoin('people_vehicles', 'people_vehicles.id', '=', 'schedules.vehicle_id')
                                ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                                ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                                ->select(
                                        'schedules.captain_id',
                                        'schedules.id as schedule_id',
                                        'schedules.fare',
                                        'schedules.vacant_seat',
                                        'schedules.schedule_date',
                                        
                                        'schedules.start_time',
                                        'schedules.end_time',
                                        'schedules.start_date',
                                        'schedules.end_date',
                                        
                                        'people.fname as cap_name',

                                        'people_vehicles.make',
                                        'people_vehicles.modal',
                                        DB::raw('(CASE 
                                            WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                            ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                            END) AS profile_pic'
                                        ),

                                        DB::raw('CONCAT(schedules.pickup_address,  ",  ", p_city.name) as pickup_address'),
                                        DB::raw('CONCAT(schedules.dropoff_address,  ",  ", d_city.name) as dropoff_address'),
                                    )
                                ->get();

        $sh                 = array();
        
        foreach ($schedules as $key => $value) {
            $schdle_id  = $value->schedule_id;
            $bkings     = $this->count_bookings($schdle_id);
            if( ($value->vacant_seat)  > $bkings ){
                array_push($sh,$value);
            }
        }
        
        $schedules          = $this->append_rating($sh);
        $tot_schedules      = $this->count_schedules($request->people_id);

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Schedules fetched by time successfully",
                                'data'          => [
                                                        'schedules' => $sh,
                                                        'tot_schedules' => $tot_schedules
                                                ]
                            ], 200);
    }

    public function fetch_cancel_reasons()
    {
        $reasons      = Reason::orderBy('id')
                            ->select(
                                        'id as reason_id',
                                        'name as reason_name'
                                    )
                            ->where('active',1)
                            ->get();

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Reason fetched successfully",
                                "data"          => [
                                                    'reasons' =>  $reasons
                                                ]
                            ], 200);
    }

    public function fetch_ratings()
    {
        $ratings      = Rating::orderBy('id')
                            ->select(
                                        'id as rating_id',
                                        'name as rating_name',
                                        'star as rating_star',
                                        'comment as rating_comment'
                                    )
                            ->where('active',1)
                            ->get();

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Rating fetched successfully",
                                "data"          => [
                                                    'ratings' =>  $ratings
                                                ]
                            ], 200);
    }

    public function fetch_provinces()
    {
        $provinces      = Province::orderBy('id')
                            ->select(
                                        'id as province_id',
                                        'name as province_name'
                                    )
                            ->where('active',1)
                            ->get();

        $cities         = City::orderBy('province_id')
                            ->select(
                                        'province_id',
                                        'id as city_id',
                                        'name as city_name',
                                        'lat as city_lat',
                                        'lng as city_lng'
                                    )
                            ->where('active',1)
                            ->get();


        foreach ($provinces as $key => $province) {
            $cts        = [];
            foreach ($cities as $k => $city) {
                if($city->province_id == $province->province_id){
                    array_push($cts, $city);
                }
            }
            $provinces[$key]->cities = $cts;
        }

        return Response::json([
                                'status'        => "success",
                                'msg'           => "Provinces fetched successfully",
                                "data"          => [
                                                    'provinces' =>  $provinces
                                                ]
                            ], 200);
    }

    public function fetch_cities()
    {
        $record     = City::select('id','name','lat','lng')->where('active',1)->get()->toArray();
        return Response::json([
                                'status'        => "success",
                                'msg'           => "Cities fetched successfully",
                                "data"          => [
                                                    'cities' =>  $record
                                                ]
                            ], 200);
    }
    
    public function update_profile(MainRequest $request)
    {
        $token              = null;
        $record             = People::where('contact_no', $request->contact_no)->first();
        $record_details     = People_detail::where('people_id', $record->id)->first();

        // BEGIN :: checking is valid contact no
        if(empty($record)){
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'Couldn\'t find your Account.',
                                    "data"      => []
                                ], 404);
        }
        // END :: checking is valid contact no

        // BEGIN :: checking is password valid 
        if(isset($request->old_password)){

            if(!(isset($request->new_password))){
                return Response::json([
                    'status'    => "failed",
                    'msg'       => 'please enter new password',
                    "data"      => []
                ], 404);
            }

            if(!(Hash::check($request->old_password, $record->password))) {
                return Response::json([
                    'status'    => "failed",
                    'msg'       => 'Invalid password',
                    "data"      => []
                ], 404);
            }
        }

        // END :: checking is password valid 


        try {
            // Transaction
            $exception = DB::transaction(function()  use ($request,$record,$record_details,$token) {
          
                // update profile with or without password 
                if(isset($request->old_password)){
                
                    // update fname and password
                    $record->update([
                        'fname'      => $request->fname,
                        'password'   => Hash::make($request->new_password),
                    ]);
                    
                   
                    // delete all previous tokens of this ID
                    $record->tokens()
                        ->where('tokenable_id', $record->id)
                        ->where('name', 'people-token')
                        ->delete();

                }else{
                    $record->update([
                        'fname'      => $request->fname
                    ]);
                }
      
                // input variables 
                $req                = $request->all();
                $input              = $request->all();   
                $req['people_id']   = $record->id;

                // BEING :: uploading image
                if( (array_key_exists("profile_pic",$input)) && (!empty($input['profile_pic']))  ){
        
                    // delete the previous image
                    if(isset($record_details->profile_pic)){
                        if (file_exists( public_path('uploads/peoples/'.$record_details->profile_pic) )){
                            unlink(public_path('uploads/peoples/'.$record_details->profile_pic));
                        }
                    }

                    $image                  = $request->file('profile_pic');
                    $input['profile_pic']   = rand().'.'.$image->getClientOriginalExtension();
                                              $image->move(public_path("uploads/peoples"),$input['profile_pic']);
        

                    // if details not exists
                    if ($record_details !== null) {
                        $record_details->update([
                            'email'       => $request->email,
                            'profile_pic' => $input['profile_pic']
                        ]);
                    } else {
                        $record_details = People_detail::create([
                            'people_id'   => $record->id,
                            'email'       => $request->email,
                            'profile_pic' => $input['profile_pic']
                        ]);
                    }

                    // People_detail::updateOrCreate(
                    //     ['people_id'    => $record->id],
                    //     ['email'        => $request->email],
                    //     ['profile_pic'  => $input['profile_pic']]
                    // );
                 
                }else{
                    // People_detail::updateOrCreate(
                    //     ['people_id'    => $record->id],
                    //     ['email'        => $request->email]
                    // );

                    // if details not exists
                    if ($record_details !== null) {
                        $record_details->update([
                            'email'       => $request->email
                        ]);
                    } else {
                        $record_details = People_detail::create([
                            'people_id'   => $record->id,
                            'email'       => $request->email,
                        ]);
                    }
                    
                }
            });

            
            if(is_null($exception)) {
                // create new token for this ID
                
                $record_details     = People_detail::where('people_id', $record->id)->first();
                $token              = (isset($request->old_password)) ? $record->createToken('people-token')->plainTextToken: null;
                $pth                = ((isset($record_details->profile_pic))) ? ( "public/uploads/peoples/".($record_details->profile_pic)) : ("public/uploads/no_image.png");
                $email              = (isset($record_details->email)) ? ($record_details->email):"" ;

                if($token != null){
                    return Response::json([
                        'status'        => "success",
                        'msg'           => "Profile updated & new token generated successfully",
                        "data"          => [
                                                'token'         => $token,
                                                'people_id'     => $record->id,
                                                'fname'         => $record->fname,
                                                'contact_no'    => $record->contact_no,
                                                'email'         => $email,
                                                'profile_pic'   => $pth
                                        ]
                    ], 200);

                }else{
                    return Response::json([
                        'status'        => "success",
                        'msg'           => "Profile updated successfully",
                        "data"          => [
                                                'people_id'     => $record->id,
                                                'fname'         => $record->fname,
                                                'contact_no'    => $record->contact_no,
                                                'email'         => $email,
                                                'profile_pic'   => $pth
                                        ]
                    ], 200);
                }
            }else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong',
                "data"      => $e
            ], 404);
        }
    }
    
    public function store_people_vehicle(MainRequest $request)
    {
        $people_vehicle        =  People_vehicle::where('people_id', $request->people_id)->first();
      
        if (( empty($people_vehicle)) ){
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Please complete the registration first',
                "data"      => []
            ], 404);
        }

        
        $rcd                = $request->all();

        if( (array_key_exists("tax_pic",$rcd)) && (!empty($rcd['tax_pic']))  ){

            // delete the previous image
            if(isset($people_vehicle->tax_pic)){
                if (file_exists( public_path('uploads/licenses/'.$people_vehicle->tax_pic) )){
                    unlink(public_path('uploads/licenses/'.$people_vehicle->tax_pic));
                }
            }

            // move the image to the licenses directory
            $image                  = $request->file('tax_pic');
            $rcd['tax_pic']       = rand().'.'.$image->getClientOriginalExtension();
                                    $image->move(public_path("uploads/licenses"),$rcd['tax_pic']);

        }


        // BEGIN::store detail in People_vehicle table
            $rcd                = People_vehicle::create($rcd);
        // END::store detail in People_vehicle table

        return Response::json([
                                'status'        => "success",
                                'msg'           => "vehicle added successfully",
                                'data'          =>  [
                                                        'people_id'            => $rcd->people_id,
                                                        'vehicle_id'           => $rcd->id,
                                                        'vehicle_registration' => $rcd->vehicle_registration,
                                                        'make'                 => $rcd->make,
                                                        'modal'                => $rcd->modal,
                                                        'car_year'             => $rcd->car_year,
                                                        'color'                => $rcd->color,
                                                        'seat'                 => $rcd->seat
                                                    ]
                            ], 200);
    }

    public function update_people_vehicle(MainRequest $request)
    {
        $pth                    = "public/uploads/no_image.png";
        $record                 = $request->all();  
        $people_vehicle         = People_vehicle::where('id',$request->vehicle_id)->first();

        // if vehicle exists 
        if(isset( $people_vehicle->id )){
            // uploading image
            if( (array_key_exists("tax_pic",$record)) && (!empty($record['tax_pic']))  ){

                // delete the previous image
                if(isset($people_vehicle->tax_pic)){
                    if (file_exists( public_path('uploads/licenses/'.$people_vehicle->tax_pic) )){
                        unlink(public_path('uploads/licenses/'.$people_vehicle->tax_pic));
                    }
                }

                // move the image to the licenses directory
                $image                  = $request->file('tax_pic');
                $record['tax_pic']      = rand().'.'.$image->getClientOriginalExtension();
                                          $image->move(public_path("uploads/licenses"),$record['tax_pic']);
            }

            $people_vehicle->update($record);

            if(isset($people_vehicle->tax_pic)){
                $pth = "public/uploads/licenses/".($people_vehicle->tax_pic);  
            }
            return Response::json([
                                    'status'        => "success",
                                    'msg'           => "Update successfully",
                                    'data'          =>  [
                                                            'people_id'            => $people_vehicle->people_id,
                                                            'vehicle_id'           => $people_vehicle->id,
                                                            'vehicle_registration' => $people_vehicle->vehicle_registration,
                                                            'make'                 => $people_vehicle->make,
                                                            'car_year'             => $people_vehicle->car_year,
                                                            'seat'                 => $people_vehicle->seat,
                                                            'color'                => $people_vehicle->color,
                                                            'modal'                => $people_vehicle->modal,
                                                            'tax_pic'              => $pth
                                                        ]
                                ], 200);

        }else{
            return Response::json([
                'status'    => "failed",
                'msg'       => 'No vehicle found!',
                "data"      => []
            ], 404);

        }
       
    }

    // public function active_vehicle(MainRequest $request){

        // $upd                = People_vehicle::where('bookings.active',1)
        //                         ->where('bookings.schedule_id',$request->schedule_id)
        //                         ->where('bookings.status_id','<=',3)
        //                         ->update(['status_id' =>  env('STATUS_CANCEL_ID') ]);

    // }

    public function fetch_people_vehicle(MainRequest $request)
    {
        $people_vehicles       =  People_vehicle::where('people_vehicles.people_id',$request->people_id)
                                    ->select(
                                            'id as vehicle_id',
                                            'vehicle_registration',
                                            'make',
                                            'modal',
                                            'car_year',
                                            'color',
                                            'seat',
                                            'active', // active: 1 OR active : 0

                                            DB::raw('(CASE 
                                                WHEN isNULL(people_vehicles.tax_pic) THEN "public/uploads/no_image.png" 
                                                ELSE CONCAT("public/uploads/licenses/",people_vehicles.tax_pic)
                                                END) AS tax_pic'
                                            )
                                            
                                        )
                                    ->get();
                                    
        if(count($people_vehicles) < 3){
            $people_vehicles = (count($people_vehicles) <=3) ?  $people_vehicles->push(((object) array("vehicle_id" => "0"))) : $people_vehicles;
        }
        
        if(count($people_vehicles) > 0){

            // $people_vehicles = (count($people_vehicles) <=3) ?  $people_vehicles->push(((object) array("vehicle_id" => "0"))) : $people_vehicles;
          
            return Response::json([
                'status'        => "success",
                'msg'           => "vehicle fetched by people successfully",
                'data'          => [
                                        'people_vehicles' =>  $people_vehicles 
                                ]
            ], 200);
            
        }else{
            return Response::json([
                'status'        => "success",
                'msg'           => "no vehicle found",
                'data'          => [
                                        'people_vehicles' =>  []
                                ]
            ], 200);
        }
        
    }
    
    public function logout()
    {
        $record         = request()->user(); 
       
        if($record){

            // Revoke current user token
            $record->tokens()->where('id', $record->currentAccessToken()->id)->delete();
            return Response::json([
                                    'status'  => "success",
                                    'data'   => "logout successfully"
                                ], 200);
        }else{
            return Response::json([
                                    'status'    => "failed",
                                    'msg'       => 'token not found',
                                ], 404);
        }
    }
}


