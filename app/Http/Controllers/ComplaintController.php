<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
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
        return view('complaints.index');
    }

    public function list()
    {
        $data   = Complaint::orderBy('complaints.name')
                    ->select(
                                'complaints.id',
                                'complaints.name',
                                'complaints.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="complaints/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="complaints/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_complaint') .'" data-id="'.$data->id.'">
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

    public function show($id)
    {
        $data         = Complaint::findorFail($id);
        return view('complaints.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Complaint::findorFail($id);
        return view('complaints.edit',compact('data'));
    }


    public function update(ComplaintRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Complaint::findOrFail($id);
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
        $data   = Complaint::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Payment method deleted successfully."]);
    }




}
