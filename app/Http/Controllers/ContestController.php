<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Contest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ContestRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:contest-list', ['only' => ['index','show']]);
         $this->middleware('permission:contest-create', ['only' => ['create','store']]);
         $this->middleware('permission:contest-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contest-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

            return view('contests.index');
    }

    public function list()
    {
        if(Auth::user()->id == 1){
            $data   = Contest::orderBy('contests.name')
                    ->select(
                                'contests.id',
                                'contests.user_id',
                                'contests.name',
                                'contests.start_date',
                                'contests.active'
                            )
                    ->get();
            }else{
                $data   = Contest::orderBy('contests.name')
                ->where('contests.user_id', Auth::user()->id )
                    ->select(
                                'contests.id',
                                'contests.user_id',
                                'contests.name',
                                'contests.start_date',
                                'contests.active'
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
                        <a class="btn btn-dark btn-xs" href="contests/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="contests/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_contest') .'" data-id="'.$data->id.'">
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
        $user     = User::pluck('name','id')->all();
        $user_id  = Auth::user()->id;
        return view('contests.create', compact('user','user_id'));
    }

    public function store(ContestRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Contest::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Contest::findorFail($id);
        return view('contests.show',compact('data'));
    }


    public function edit($id)
    {
        $data           = Contest::findorFail($id);
        $user           = User::pluck('name','id')->all();
        $user_id        = User::select('id')->where('id',$data->user_id)->first();

        // dd($data);
        return view('contests.edit',compact('data','user','user_id'));
    }


    public function update(ContestRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Contest::findOrFail($id);
        $input      = $request->all();
        
        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $data   = Contest::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Contest deleted successfully."]);
    }

}
