<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Client;
use App\Models\Box;
use App\Models\Product;
use App\Models\Ibeacon;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Controller;

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
        $data   = Client::orderBy('clients.fullname')
                    ->leftjoin('regions', 'regions.id', '=', 'clients.region_id')
                    ->leftjoin('countries', 'countries.id', '=', 'regions.id')
                    ->select(
                                'clients.id',
                                'clients.fullname',
                                'clients.phone_no',
                                'clients.state',
                                'countries.name as country_name',
                                'clients.profile_pic',
                                'clients.active',
                               
                            )
                    ->get();
        return 
            DataTables::of($data)
            
                ->addColumn('profile_pic',function($data){
                    return 
                        '<div class="avatar">
                            <img src="'.$data->profile_pic.'" alt="" class="avatar-img rounded-circle"  style="width:50px; height:50px">
                        </div>';
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="clients/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="clients/'.$data->id.'/edit" id="'.$data->id.'">
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
                ->rawColumns(['srno','profile_pic','','action'])
                ->make(true);
    }

    public function boxes($id)
    {
        $data       = Box::where('boxes.client_id', $id)->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No box found!']);
        }
        return view('clients.boxes',compact('data','id'));
    }

    public function fetchBoxes($client_id)
    {
        $data   = Box::where('boxes.client_id',$client_id)->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="box/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function showBox($box_id)
    {
        $data      = Box::findorFail($box_id);
        return view('clients.box',compact('data'));
    }

    public function products($id)
    {
        $data       = Product::where('products.client_id', $id)->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No product found!']);
        }
        return view('clients.products',compact('data','id'));
    }

    public function fetchProducts($client_id)
    {
        $data   = Product::where('products.client_id',$client_id)->get();
        return 
            DataTables::of($data)
                ->addColumn('added_to_mp',function($data){
                    if((isset($data->added_to_mp)) && ( ($data->added_to_mp == 1) || ($data->added_to_mp == "Yes") ) ){
                        return '<span class="badge badge-success">Yes</span>';
                    }else{
                        return '<span class="badge badge-danger">No</span>';
                    }
                })
                
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="product/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','added_to_mp','action'])
                ->make(true);
    }

    public function showProduct($product_id)
    {
        $data      = Product::findorFail($product_id);
        return view('clients.product',compact('data'));
    }

    public function ibeacons($id)
    {
        $data       = Ibeacon::where('ibeacons.client_id', $id)->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No ibeacon found!']);
        }
        return view('clients.ibeacons',compact('data','id'));
    }
    
    public function fetchIbeacons($client_id)
    {
        $data   = Ibeacon::where('ibeacons.client_id',$client_id)->get();

        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="ibeacon/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function showIbeacon($ibeacon_id)
    {
        $data      = Ibeacon::findorFail($ibeacon_id);
        return view('clients.ibeacon',compact('data'));
    }

    public function complaints($id)
    {
        $data       = Complaint::where('complaints.client_id', $id)->first();

        if((empty($data))){
            return Redirect::back()->withErrors(['msg' => 'No complaint found!']);
        }
        return view('clients.complaints',compact('data','id'));
    }
    
    public function fetchComplaints($client_id)
    {
        $data   = Complaint::where('complaints.client_id',$client_id)->get();

        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '<div class="btn-group btn-group">
                                <a class="btn btn-info btn-xs" href="complaint/'.$data->id.'">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>';
                })

                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function showComplaint($complaint_id)
    {
        $data      = Complaint::findorFail($complaint_id);
        return view('clients.complaint',compact('data'));
    }



    public function create()
    {
        $clients        = Client::pluck('fullname','id')->all();
        return view('clients.create',compact('clients'));
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
        $data           = Client::findorFail($id);
        $boxes          = Box::where('client_id', $id)->count();
        $products       = Product::where('client_id', $id)->count();
        $ibeacons       = Ibeacon::where('client_id', $id)->count();
        $complaints     = Complaint::where('client_id', $id)->count();

        return view('clients.show',compact(
                                            'data',
                                            'boxes',
                                            'products',
                                            'ibeacons',
                                            'complaints'
                                        ));
    }


    public function edit($id)
    {
        $data           = Client::findorFail($id);
        $provinces      = Client::pluck('name','id')->all();  
        return view('clients.edit',compact('data','provinces'));
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
