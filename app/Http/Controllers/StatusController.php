<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:status-list', ['only' => ['index','show']]);
         $this->middleware('permission:status-create', ['only' => ['create','store']]);
         $this->middleware('permission:status-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:status-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('statuses.index');
    }

    public function list()
    {
        $data   = Status::orderBy('statuses.name')
                    ->select(
                                'statuses.id',
                                'statuses.name',
                                'statuses.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="statuses/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="statuses/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_status') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(StatusRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Status::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Status::findorFail($id);
        return view('statuses.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Status::findorFail($id);
        return view('statuses.edit',compact('data'));
    }


    public function update(StatusRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Status::findOrFail($id);
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
        $data   = Status::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Status deleted successfully."]);
    }
}
