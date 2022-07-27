<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\RegionRequest;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:region-list', ['only' => ['index','show']]);
         $this->middleware('permission:region-create', ['only' => ['create','store']]);
         $this->middleware('permission:region-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:region-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('regions.index');
    }

    public function list()
    {
        $data   = Region::orderBy('regions.name')
                    ->select(
                                'regions.id',
                                'regions.name',
                                'regions.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="regions/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="regions/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_region') .'" data-id="'.$data->id.'">
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
        return view('regions.create');
    }

    public function store(RegionRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Region::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Region::findorFail($id);
        return view('regions.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Region::findorFail($id);
        return view('regions.edit',compact('data'));
    }


    public function update(RegionRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Region::findOrFail($id);
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
        $data   = Region::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Region deleted successfully."]);
    }

}
