<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Product;
use App\Models\Client;
use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('products.index');
    }

    public function list()
    {
        $data   = Product::orderBy('products.name')->get();
        return 
            DataTables::of($data)
                ->addColumn('client_name',function($data){
                    if(isset($data->client->fullname)){
                        return $data->client->fullname;
                    }else{
                        return "";
                    }
                })

                ->addColumn('added_to_mp',function($data){
                    if((isset($data->added_to_mp)) && ( ($data->added_to_mp == 1) || ($data->added_to_mp == "Yes") ) ){
                        return '<span class="badge badge-success">Yes</span>';
                    }else{
                        return '<span class="badge badge-danger">No</span>';
                    }
                })
                
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="products/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="products/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_product') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','client_name','added_to_mp','action'])
                ->make(true);
    }

    public function create()
    {
        $client       = Client::pluck('fullname','id')->all();
        $category     = Category::pluck('name','id')->all();
        $sub_category = Sub_category::pluck('name','id')->all();
        return view('products.create',compact('client','category','sub_category'));
    }

    public function store(ProductRequest $request)
    {  
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Product::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

     public function show($id)
    {
        $data         = Product::findorFail($id);

        return view('products.show',compact('data'));
    }


    public function edit($id)
    {
        // get data from pluck
        $data              = Product::findorFail($id);
        $client            = Client::pluck('fullname','id')->all();
        $category          = Category::pluck('name','id')->all();
        $sub_category      = Sub_category::pluck('name','id')->all();

        // select id on input 
        $client_id         = Client::select('id')->where('id',$data->client_id)->first();
        $category_id       = Category::select('id')->where('id',$data->category_id)->first();
        $sub_category_id   = Sub_category::select('id')->where('id',$data->sub_category_id)->first();
        return view('products.edit',compact('data','client','category','sub_category','client_id','category_id','sub_category_id'));
    }


    public function update(ProductRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Product::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        if(!(isset($input['added_to_mp']))){
            $input['added_to_mp'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $data   = Product::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Product deleted successfully."]);
    }

}
