<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:city-list', ['only' => ['index','show']]);
         $this->middleware('permission:city-create', ['only' => ['create','store']]);
         $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('cities.index');
    }

    public function list()
    {
        $data   = City::orderBy('cities.name')
                    ->leftjoin('provinces', 'provinces.id', '=', 'cities.province_id')
                    ->select(
                                'cities.id',
                                'cities.name',
                                'cities.active',
                                'provinces.name as prvnc_name'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="cities/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="cities/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_city') .'" data-id="'.$data->id.'">
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

        $provinces        = Province::pluck('name','id')->all();
        return view('cities.create',compact('provinces'));
    }

    public function store(CityRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = City::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data           = City::findorFail($id);
        $province       = City::findorFail($id)->province;

        return view('cities.show',compact(
                                            'data',
                                            'province'
                                        ));
    }


    public function edit($id)
    {
        $data           = City::findorFail($id);
        $provinces      = Province::pluck('name','id')->all();  
        return view('cities.edit',compact('data','provinces'));
    }


    public function update(CityRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = City::findOrFail($id);
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
        $data   = City::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." City deleted successfully."]);
    }

}
