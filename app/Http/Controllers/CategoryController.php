<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:category-list', ['only' => ['index','show']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

            return view('categories.index');
    }

    public function list()
    {
            $data   = Category::orderBy('categories.name')
                    ->select(
                                'categories.id',
                                'categories.name',
                                'categories.active'
                            )
                    ->get();
            return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="categories/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="categories/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_category') .'" data-id="'.$data->id.'">
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
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Category::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

    public function show($id)
    {
        $data         = Category::findorFail($id);
        return view('categories.show',compact('data'));
    }

    public function edit($id)
    {
        $data       = Category::findorFail($id);
        return view('categories.edit',compact('data'));
    }


    public function update(CategoryRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Category::findOrFail($id);
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
        $data   = Category::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Category deleted successfully."]);
    }

}
