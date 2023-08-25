<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:order-list', ['only' => ['index','show']]);
         $this->middleware('permission:order-create', ['only' => ['create','store']]);
         $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

            return view('orders.index');
    }

    public function list()
    {
        if(Auth::user()->id == 1){
            $data   = Order::orderBy('orders.name')
                    ->select(
                                'orders.id',
                                'orders.user_id',
                                'orders.name',
                                'orders.complete',
                                'orders.start_date',
                                'orders.active'
                            )
                    ->get();
            }else{
                $data   = Order::orderBy('orders.name')
                ->where('orders.user_id', Auth::user()->id )
                    ->select(
                                'orders.id',
                                'orders.user_id',
                                'orders.name',
                                'orders.complete',
                                'orders.start_date',
                                'orders.active'
                            )
                    ->get();
            }

            return 
            DataTables::of($data)
                ->addColumn('user_name',function($data){
                    if(isset($data->user->name)){
                        return $data->user->name;
                    }else{
                        return "";
                    }
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="orders/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="orders/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_order') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','user_name','','action'])
                ->make(true);
    }

    public function create()
    {
        $user     = User::pluck('name','id')->all();
        $category = Category::pluck('name','id')->all();
        $client   = Client::pluck('name','id')->all();
        $user_id  = Auth::user()->id;
        return view('orders.create', compact('user','category','client','user_id'));
    }

    public function store(OrderRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Order::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Order::findorFail($id);
        return view('orders.show',compact('data'));
    }


    public function edit($id)
    {
        $data           = Order::findorFail($id);
        $user           = User::pluck('name','id')->all();
        $category       = Category::pluck('name','id')->all();
        $client         = Client::pluck('name','id')->all();
        $user_id        = User::select('id')->where('id',$data->user_id)->first();
        $category_id    = Category::select('id')->where('id',$data->category_id)->first();
        $client_id      = Client::select('id')->where('id',$data->client_id)->first();

        // dd($data);
        return view('orders.edit',compact('data','user','category','client','user_id','category_id','client_id'));
    }


    public function update(OrderRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Order::findOrFail($id);
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
        $data   = Order::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Order deleted successfully."]);
    }

    public function get_order_data()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

}
