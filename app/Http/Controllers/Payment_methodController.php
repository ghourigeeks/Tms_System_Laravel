<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use Str;
use App\Models\Payment_method;
use Illuminate\Http\Request;
use App\Http\Requests\Payment_methodRequest;
use App\Http\Controllers\Controller;

class Payment_methodController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:payment_methods-list', ['only' => ['index','show']]);
         $this->middleware('permission:payment_methods-create', ['only' => ['create','store']]);
         $this->middleware('permission:payment_methods-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:payment_methods-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('payments_method.index');
    }

    public function list()
    {
        $data   = Payment_method::orderBy('payment_methods.name')
                    ->select(
                                'payment_methods.id',
                                'payment_methods.name',
                                'payment_methods.public_key',
                                'payment_methods.private_key',
                                'payment_methods.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('public_key',function($data){
                    return (isset($data->public_key)) ? (Str::of($data->public_key)->limit(30)) : "";
                })
                ->addColumn('private_key',function($data){
                    return (isset($data->private_key)) ? (Str::of($data->private_key)->limit(30)) : "";
                })

                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="payments/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="payments/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_payment') .'" data-id="'.$data->id.'">
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
        return view('payments_method.create');
    }


    public function store(Payment_methodRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Payment_method::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }


    public function show($id)
    {
        $data         = Payment_method::findorFail($id);
        return view('payments_method.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Payment_method::findorFail($id);
        return view('payments_method.edit',compact('data'));
    }


    public function update(Payment_methodRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Payment_method::findOrFail($id);
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
        $data   = Payment_method::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Payment Method deleted successfully."]);
    }
}
