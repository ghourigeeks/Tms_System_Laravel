<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:client-list', ['only' => ['index','show']]);
         $this->middleware('permission:client-create', ['only' => ['create','store']]);
         $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

            return view('clients.index');
    }

    public function list()
    {
            $data   = Client::orderBy('clients.name')
                    ->select(
                                'clients.id',
                                'clients.name',
                                'clients.active'
                            )
                    ->get();
            return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="clients/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="clients/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_client') .'" data-id="'.$data->id.'">
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
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Client::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

    public function show($id)
    {
        $data         = Client::findorFail($id);
        return view('clients.show',compact('data'));
    }

    public function edit($id)
    {
        $data       = Client::findorFail($id);
        return view('clients.edit',compact('data'));
    }


    public function update(ClientRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Client::findOrFail($id);
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
        $data   = Client::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Client deleted successfully."]);
    }

}
