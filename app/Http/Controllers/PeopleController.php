<?php
namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Validator;
use DataTables;
use Redirect;
use App\Models\Rating;
use App\Models\People;
use App\Models\Wallet;
use App\Models\Booking;
use App\Models\History;
use App\Models\Schedule;
use App\Models\Complaint;
use App\Models\People_detail;
use App\Models\People_vehicle;
use App\Models\People_rating;

use Illuminate\Http\Request;
use App\Http\Requests\PeopleRequest;

class PeopleController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:people-list', ['only' => ['index','show']]);
         $this->middleware('permission:people-create', ['only' => ['create','store']]);
         $this->middleware('permission:people-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:people-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('peoples.index');
    }

    public function list()
    {
        $data   = People::orderBy('people.fname')
                    ->select(
                                'people.id',
                                'people.fname',
                                'people.type',
                                'people.active',
                                'people.contact_no',
                            )
                    ->get();

        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="peoples/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="btn btn-info btn-xs" href="peoples/'.$data->id.'/edit" id="'.$data->id.'">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button
                                    class="btn btn-danger btn-xs delete_all"
                                    data-url="'. url('del_people') .'" data-id="'.$data->id.'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function schedules($id)
    {
        $data      = People::findorFail($id);
        return view('peoples.schedules',compact('data','id'));
    }

    public function schedules_lst($captain_id)
    {
        $data   = Schedule::orderBy('schedules.id')
                    ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                    ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                    ->leftjoin('statuses', 'statuses.id', '=', 'schedules.status_id')
                    ->select(
                                'schedules.id',
                                'schedules.vacant_seat',
                                'schedules.fare',
                                'p_city.name as pickup_city',
                                'd_city.name as dropoff_city',
                                'schedules.schedule_time',
                                'statuses.name as status_name'

                            )
                    ->where('schedules.captain_id',$captain_id)
                    ->get();

        return 
            DataTables::of($data)
                
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="shdl/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function bookings($id)
    {
        $data       = Booking::where('bookings.passenger_id', $id)
                        ->leftjoin('people', 'people.id', '=', 'bookings.passenger_id')
                        ->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No booking found!']);
        }
        return view('peoples.bookings',compact('data','id'));
    }

    public function ratings($id)
    {
        $data       = People_rating::where('people_ratings.captain_id', $id)
                        ->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No rating found!']);
        }


        return view('peoples.ratings',compact('data','id'));
    }

    public function ratings_lst($captain_id)
    {
        $data   = People_rating::orderBy('people_ratings.id')
                    ->leftjoin('people', 'people.id', '=', 'people_ratings.passenger_id')
                    ->select(
                                'people_ratings.id',
                                'people_ratings.rating',
                                'people.fname as pas_name',
                            )
                    ->where('people_ratings.captain_id',$captain_id)
                    ->get();
        return 
            DataTables::of($data)
                ->editColumn('rating', function ($request) {
                    $cde = null; 
                    for($i=0; $i<5; $i++){
                        if($i < ($request->rating))
                            $cde .= '<i class="fa fa-star text-warning" ></i>';
                        else
                            $cde .= '<i class="fa fa-star" ></i>';
                    }
                    return $cde;
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','rating'])
                ->make(true);

    }

    public function complaints($id)
    {
   
        $data       = Complaint::where('complaints.captain_id', $id)
                        ->leftjoin('people', 'people.id', '=', 'complaints.captain_id')
                        ->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No complaint found!']);
        }

        return view('peoples.complaints',compact('data','id'));
    }

    public function complaints_lst($captain_id)
    {
        $data   = Complaint::orderBy('complaints.id')
                    ->leftjoin('people', 'people.id', '=', 'complaints.passenger_id')
                    ->leftjoin('complaint_tags', 'complaint_tags.id', '=', 'complaints.complaint_tag_id')
                    ->select(
                                'complaints.id',
                                'people.fname as pas_name',
                                'complaint_tags.name as com_name',
                                'complaints.detail',
                                // 'passengers.id as pas_id',
                                // 'complaints.id as com_id',

                            )
                    ->where('complaints.captain_id',$captain_id)
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('srno','')
                ->rawColumns(['srno',''])
                ->make(true);
    }

    public function bookings_lst($passenger_id)
    {
        $data   = Booking::orderBy('bookings.id')
                    ->leftjoin('schedules', 'schedules.id', '=', 'bookings.schedule_id')
                    ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                    ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                    ->leftjoin('statuses', 'statuses.id', '=', 'bookings.status_id')
                    ->select(
                                'schedules.id',
                                'bookings.book_seat',
                                'schedules.fare',
                                'p_city.name as pickup_city',
                                'd_city.name as dropoff_city',
                                'schedules.schedule_time',
                                'statuses.name as status_name'

                            )
                    ->where('bookings.passenger_id',$passenger_id)
                    ->get();

        return 
            DataTables::of($data)
                
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="bkngs/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function schedule_show($schedule_id)
    {
        
        $data      = Schedule::orderBy('schedules.id')
                        ->leftjoin('cities as p_city', 'p_city.id', '=', 'schedules.pickup_city_id')
                        ->leftjoin('cities as d_city', 'd_city.id', '=', 'schedules.dropoff_city_id')
                        ->leftjoin('statuses', 'statuses.id', '=', 'schedules.status_id')
                        ->leftjoin('people', 'people.id', '=', 'schedules.captain_id')
                        ->leftjoin('reasons', 'reasons.id', '=', 'schedules.cancel_reason_id')
                        ->select(
                                    'schedules.id',

                                    'schedules.fare',
                                    'schedules.vacant_seat',
                                    'schedules.created_at',
                                    
                                    'schedules.pickup_address',
                                    'schedules.dropoff_address',

                                    'p_city.name as pickup_city',
                                    'd_city.name as dropoff_city',

                                    'schedules.schedule_time',

                                    'schedules.cancel_reason_id',
                                    'schedules.cancel_reason',

                                    'people.id as cap_id',
                                    'people.fname as cap_name',
                                    'reasons.name',

                                    'statuses.id as status_id',
                                    'statuses.name as status_name'
                                )
                        ->findorFail($schedule_id);

        $passengers = Booking::orderBy('bookings.id')
                        ->leftjoin('statuses', 'statuses.id', '=', 'bookings.status_id')
                        ->leftjoin('people', 'people.id', '=', 'bookings.passenger_id')
                        ->leftjoin('reasons', 'reasons.id', '=', 'bookings.cancel_reason_id')
                        ->select(
                                    'bookings.id as schedule_id',
                                    'bookings.book_seat',
                                    'bookings.created_at',
                                    
                                    'reasons.name',
                                    'people.id as pas_id',
                                    'people.fname as pas_name',

                                    'statuses.id as status_id',
                                    'statuses.name as status_name'
                                )
                        ->where('bookings.schedule_id',$schedule_id)
                        ->get();

                        


        $histories  = History::orderBy('histories.id')
                        ->leftjoin('statuses', 'statuses.id', '=', 'histories.status_id')
                        ->select(
                                    'histories.id',
                                    'statuses.id as status_id',
                                    'statuses.name as status_name',
                                    'histories.created_at',
                                )
                        ->where('histories.type',1)  // 1:Captain
                        ->where('histories.people_id',$data->cap_id)
                        ->where('histories.schedule_id',$schedule_id)
                        ->get();

                       
        return view('peoples.schedule',compact(
                                            'data',
                                            'schedule_id',
                                            'passengers',
                                            'histories'
                                        ));
    }
    
    public function create()
    {
        return view('peoples.create');
    }

    public function store(PeopleRequest $request)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $input       = $request->all();

        // uploading image
        if(!empty($input['profile_pic'])){
            $input['profile_pic'] = rand().'.'.$request->profile_pic->extension();  
            $request->profile_pic->move(public_path("uploads/peoples"), $input['profile_pic']);
        }

        // creating encrypted password
        $input['password']          = Hash::make($input['password']);

        $data                       = People::create($input);
        return response()->json(['success'=>$request['fname']. ' added successfully.']);
    }

    
    public function show($id)
    {
        $data       = People::findorFail($id);
        $detail     = People_detail::where('people_id',$id)->first();
        $ratings    = round(People_rating::where('captain_id',$id)->avg('rating'));
        $vehicles   = People_vehicle::where('people_id',$id)->get();
        $bookings   = Booking::where('passenger_id', $id)->count();
        $schedules  = Schedule::where('captain_id', $id)->count();
        $complaints = Complaint::where('captain_id', $id)->count();

        
        return view('peoples.show',compact(
                                            'data',
                                            'detail',
                                            'ratings',
                                            'vehicles',
                                            'bookings',
                                            'schedules',
                                            'complaints',
                                        ));
    }

   
    public function edit($id)
    {
        $data       = People::findorFail($id);

        return view('peoples.edit',compact('data'));
    }

    
    public function update(PeopleRequest $request, $id)
    {


        // get all request
        $data       = People::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // password 
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input['password'] = $data['password'];
        }

        // image
        if(!(empty($input['profile_pic']))){

            // delete the previous image
            if($data['profile_pic']!=""){
                unlink(public_path('uploads/peoples/'.$data['profile_pic']));
            }

            // upload the new image
            $input['profile_pic'] = rand().'.'.$request->profile_pic->extension();  
            $request->profile_pic->move(public_path("uploads/peoples"), $input['profile_pic']);
        }else{
            $input['profile_pic']   = $data['profile_pic'];
        }

        $data->update($input);
        return response()->json(['success'=>$request['fname']. ' updated successfully.']);
    }

    
    public function destroy(Request $request)
    {
        // $data   = People::whereIn('id',explode(",", $request->ids))->delete();
        $data   = DB::table("people")->whereIn('id',explode(",",$request->ids))->delete();
        return response()->json(['success'=>$data." People deleted successfully."]);
    }
}
