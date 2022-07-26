<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\ProvinceRequest;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:province-list', ['only' => ['index','show']]);
         $this->middleware('permission:province-create', ['only' => ['create','store']]);
         $this->middleware('permission:province-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:province-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('provinces.index');
    }

    public function list()
    {
        $data   = Province::orderBy('provinces.name')
                    ->select(
                                'provinces.id',
                                'provinces.name',
                                'provinces.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="provinces/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="provinces/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_province') .'" data-id="'.$data->id.'">
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
        return view('provinces.create');
    }

    public function store(ProvinceRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Province::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Province::findorFail($id);
        return view('provinces.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Province::findorFail($id);
        return view('provinces.edit',compact('data'));
    }


    public function update(ProvinceRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Province::findOrFail($id);
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
        $data   = Province::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Province deleted successfully."]);
    }

}
