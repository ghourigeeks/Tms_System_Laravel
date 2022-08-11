<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Box;
use App\Models\Client;
use App\Models\Box_product;
use Illuminate\Http\Request;
use App\Http\Requests\BoxRequest;
use App\Http\Controllers\Controller;

class BoxController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:box-list', ['only' => ['index','show']]);
         $this->middleware('permission:box-create', ['only' => ['create','store']]);
         $this->middleware('permission:box-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:box-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('boxes.index');
    }

    public function list()
    {
        $data   = Box::orderBy('boxes.name')
                    ->select(
                                'boxes.id',
                                'boxes.client_id',
                                'boxes.name',
                                'boxes.price',
                                'boxes.barcode',
                                'boxes.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('client_name',function($data){
                    if(isset($data->client->fullname)){
                        return $data->client->fullname;
                    }else{
                        return "";
                    }
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="boxes/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="boxes/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_box') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','client_name','','action'])
                ->make(true);
    }


    public function create()
    {
        $clients = Client::pluck('fullname','id')->all();
        return view('boxes.create',compact('clients'));
    }


    public function store(BoxRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Box::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }


    public function show(Box $box)
    {
        $data         = Box::findorFail($box->id);
        $boxProducts  = Box_product::where('box_id', $box->id)->get();


        return view('boxes.show',compact('data','boxProducts'));
    }


    public function edit(Box $box)
    {
        $clients = Client::pluck('fullname','id')->all();
        $data         = Box::findorFail($box->id);
        // dd($data);
        return view('boxes.edit',compact('data','clients'));
    }


    public function update(BoxRequest $request,Box  $box)
    {
        // dd($box);
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Box::findOrFail($box->id);
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
        $data   = Box::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Box deleted successfully."]);
    }
}
