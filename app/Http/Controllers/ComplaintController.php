<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use Str;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintRequest;

class ComplaintController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:complaint-list', ['only' => ['index','show']]);
         $this->middleware('permission:complaint-create', ['only' => ['create','store']]);
         $this->middleware('permission:complaint-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complaint-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $complaints = Complaint::where('res', '')->orwhere('res', null)->get();
        return view('complaints.index',compact('complaints'));
    }

    public function list()
    {
        $data   = Complaint::get();
        return 
            DataTables::of($data)
                ->addColumn('profile_pic',function($data){
                    if(isset($data->client->profile_pic)){
                        return '  <div class="list-group-item-figure">
                        <a href="complaints/'.$data->id.'" class="user-avatar">
                            <div class="avatar">
                                <img src="'.$data->client->profile_pic.'" alt="..." class="avatar-img rounded-circle">
                            </div>
                        </a>
                    </div>';
                    }else{
                        return "";
                    }
                    
                })
                ->addColumn('client_name',function($data){
                    if(isset($data->client->fullname)){
                        $sub = (isset($data->subject)) ? (Str::of($data->subject)->limit(30)) : "";
                        
                        return 
                                '
                                <div class="list-group-item-body pl-3 pl-md-4">
                                    <h4 class="list-group-item-title">
                                        <a href="complaints/'.$data->id.'">
                                            '.$data->client->fullname.'
                                        </a>
                                    </h4>
                                    <p class="list-group-item-text text-truncate">'.$sub.'</p>
                                </div>';
                    }else{
                        return "";
                    }
                })
               
                ->addColumn('srno','')
                ->rawColumns(['srno','profile_pic','client_name',''])
                ->make(true);
    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(ComplaintRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Complaint::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

    public function show(Complaint $complaint)
    {
        $data         = Complaint::findorFail($complaint->id);
        return view('complaints.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Complaint::findorFail($id);
        return view('complaints.edit',compact('data'));
    }


    public function update(ComplaintRequest $request,Complaint $complaint)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Complaint::findOrFail($complaint->id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return view('complaints.show',compact('data'));
    }

    public function destroy(Request $request)
    {
        $data   = Complaint::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Payment method deleted successfully."]);
    }




}
