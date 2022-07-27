<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:country-list', ['only' => ['index','show']]);
         $this->middleware('permission:country-create', ['only' => ['create','store']]);
         $this->middleware('permission:country-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:country-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('countries.index');
    }

    public function list()
    {
        $data   = Country::orderBy('countries.name')
                    ->select(
                                'countries.id',
                                'countries.name',
                                'countries.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="countries/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="countries/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_country') .'" data-id="'.$data->id.'">
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
        $region = Region::pluck('name','id')->all();
        return view('countries.create',compact('region'));
    }

    public function store(CountryRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Country::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Country::findorFail($id);
        return view('countries.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Country::findorFail($id);
        $region       = Region::pluck('name','id')->all();
        $region_id    = Region::select('id')->where('id',$data->region_id)->first();
        return view('countries.edit',compact('data','region','region_id'));
    }


    public function update(CountryRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Country::findOrFail($id);
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
        $data   = Country::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Country deleted successfully."]);
    }

}
