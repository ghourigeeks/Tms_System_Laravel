<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Ibeacon;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\IbeaconsRequest;
use App\Http\Controllers\Controller;

class IbeaconController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:ibeacon-list', ['only' => ['index','show']]);
         $this->middleware('permission:ibeacon-create', ['only' => ['create','store']]);
         $this->middleware('permission:ibeacon-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ibeacon-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('ibeacons.index');
    }


    public function list()
    {
        $data   = Ibeacon::orderBy('ibeacons.id')->get();
        return 
            DataTables::of($data)
                ->addColumn('client_name',function($data){
                    if(isset($data->client->fullname)){
                        return $data->client->fullname;
                    }else{
                        return "";
                    }
                })
<<<<<<< Updated upstream
                
=======
>>>>>>> Stashed changes
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="ibeacons/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="ibeacons/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_ibeacon') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
<<<<<<< Updated upstream
                ->rawColumns(['srno','','client_name','action'])
                ->make(true);    
}
=======
                ->rawColumns(['srno','client_name','','action'])
                ->make(true);
    }

>>>>>>> Stashed changes

    public function create()
    {
        $clients = Client::pluck('fullname','id')->all();
        return view('ibeacons.create',compact('clients'));
    }


    public function store(IbeaconsRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Ibeacon::create($request->all());
        return response()->json(['success'=>'Ibeacon added successfully.']);
    }


    public function show(Ibeacon $ibeacon)
    {
        $data         = Ibeacon::findorFail($ibeacon->id);
        return view('ibeacons.show',compact('data'));
    }


    public function edit(Ibeacon $ibeacon)
    {
        $clients = Client::pluck('fullname','id')->all();
        $data         = Ibeacon::findorFail($ibeacon->id);
        // dd($data);
        return view('ibeacons.edit',compact('data','clients'));
    }


    public function update(IbeaconsRequest $request,Ibeacon  $ibeacon)
    {
        // dd($box);
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Ibeacon::findOrFail($ibeacon->id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>'Ibeacon updated successfully.']);
    }


    public function destroy(Request $request)
    {
        $data   = Ibeacon::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>"Ibeacon deleted successfully."]);
    }
}
