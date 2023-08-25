<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:leave-list', ['only' => ['index','show']]);
         $this->middleware('permission:leave-create', ['only' => ['create','store']]);
         $this->middleware('permission:leave-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:leave-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
            return view('leaves.index');
    }

    public function list()
    {
        if(Auth::user()->id == 1){
            $data   = Leave::orderBy('leaves.subject')
                    ->select(
                                'leaves.id',
                                'leaves.user_id',
                                'leaves.subject',
                                'leaves.created_at',
                                'leaves.active'
                            )
                    ->get();
            }else{
                $data   = Leave::orderBy('leaves.subject')
                ->where('leaves.user_id', Auth::user()->id )
                    ->select(
                                'leaves.id',
                                'leaves.user_id',
                                'leaves.subject',
                                'leaves.created_at',
                                'leaves.active'
                            )
                    ->get();
            }

            return 
            DataTables::of($data)
                ->addColumn('user_name',function($data){
                    if(isset($data->user->name)){
                        return $data->user->name;
                    }else{
                        return "";
                    }
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="leaves/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_leave') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','user_name','','action'])
                ->make(true);
    }


    public function create()
    {
        $user           = User::pluck('name','id')->all();
        $user_email     = User::pluck('email','id')->all();
        $user_contact   = User::pluck('contact_no','id')->all();
        $user_id        = Auth::user()->id;
        return view('leaves.create', compact('user','user_email','user_contact','user_id'));
    }

    public function store(LeaveRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Leave::create($request->all());
        return response()->json(['success'=>$request['subject']. ' added successfully.']);
      
    }


    public function show($id)
    {
        $data         = Leave::findorFail($id);
        return view('leaves.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Leave::findorFail($id);
        return view('leaves.edit',compact('data'));
    }


    public function update(Request $request, $id)
    {

        // get all request
        $data       = Leave::findOrFail($id);
        $input      = $request->all();


        // update
        $upd        = $data->update($input);
        return view('leaves.show',compact('data'));
    }
    
    public function destroy(Request $request)
    {
        $data   = Leave::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Leave deleted successfully."]);
    }
}
