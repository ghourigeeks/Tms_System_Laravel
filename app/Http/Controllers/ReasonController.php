<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReasonRequest;

class ReasonController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:reason-list', ['only' => ['index','show']]);
         $this->middleware('permission:reason-create', ['only' => ['create','store']]);
         $this->middleware('permission:reason-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:reason-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('reasons.index');
    }

    public function list()
    {
        $data   = Reason::orderBy('reasons.name')
                    ->select(
                                'reasons.id',
                                'reasons.name',
                                'reasons.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="reasons/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="reasons/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_reason') .'" data-id="'.$data->id.'">
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
        return view('reasons.create');
    }

    public function store(ReasonRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Reason::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Reason::findorFail($id);
        return view('reasons.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Reason::findorFail($id);
        return view('reasons.edit',compact('data'));
    }


    public function update(ReasonRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Reason::findOrFail($id);
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
        $data   = Reason::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Reason deleted successfully."]);
    }
}
