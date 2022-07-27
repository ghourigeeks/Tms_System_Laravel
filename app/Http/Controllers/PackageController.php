<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:package-list', ['only' => ['index','show']]);
         $this->middleware('permission:package-create', ['only' => ['create','store']]);
         $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('packages.index');
    }

    public function list()
    {
        $data   = Package::orderBy('packages.name')
                    ->select(
                                'packages.id',
                                'packages.name',
                                'packages.amount',
                                'packages.box_limit',
                                'packages.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="packages/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="packages/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_package') .'" data-id="'.$data->id.'">
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
        return view('packages.create');
    }

    public function store(PackageRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Package::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    public function show($id)
    {
        $data         = Package::findorFail($id);
        return view('packages.show',compact('data'));
    }

    public function edit($id)
    {
        $data         = Package::findorFail($id);
        return view('packages.edit',compact('data'));
    }

    public function update(PackageRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Package::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active

        if(!(isset($input['add_to_mp']))){
            $input['add_to_mp'] = 0;
        }

        if(!(isset($input['ibeacon']))){
            $input['ibeacon'] = 0;
        }


        if(!(isset($input['barcode']))){
            $input['barcode'] = 0;
        }


        if(!(isset($input['qrcode']))){
            $input['qrcode'] = 0;
        }


        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $data   = Package::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Package deleted successfully."]);
    }
}
