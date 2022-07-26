<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use Illuminate\Http\Request;
use App\Models\Complaint_tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Complaint_tagRequest;

class Complaint_tagController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:complaint_tag-list', ['only' => ['index','show']]);
         $this->middleware('permission:complaint_tag-create', ['only' => ['create','store']]);
         $this->middleware('permission:complaint_tag-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complaint_tag-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('complaint_tags.index');
    }

    public function list()
    {
        $data   = Complaint_tag::orderBy('complaint_tags.name')
                    ->select(
                                'complaint_tags.id',
                                'complaint_tags.name',
                                'complaint_tags.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="complaint_tags/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="complaint_tags/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_complaint_tag') .'" data-id="'.$data->id.'">
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
        return view('complaint_tags.create');
    }

    public function store(Complaint_tagRequest $request)
    {
        Complaint_tag::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    public function show($id)
    {
        $data         = Complaint_tag::findorFail($id);
        return view('complaint_tags.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Complaint_tag::findorFail($id);
        return view('complaint_tags.edit',compact('data'));
    }


    public function update(Complaint_tagRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Complaint_tag::findOrFail($id);
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
        $data   = Complaint_tag::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Complaint tag deleted successfully."]);
    }




}
