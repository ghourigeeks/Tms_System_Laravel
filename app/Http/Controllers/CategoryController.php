<?php
namespace App\Http\Controllers;

use DB;
use Response;
use Auth;
use DataTables;
use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

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
                        <a class="btn btn-info btn-xs" href="categories/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="categories/'.$data->id.'/edit" id="'.$data->id.'">
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
        try {
            // Transaction
            $exception = DB::transaction(function() use ($request){ 

                // Creating a single category
                $category = Category::create([
                    'name' => $request->name,
                    'created_by' => Auth::user()->id
                ]); 

                if((isset($request->sub_cat)) && (!(empty($request->sub_cat))) && (count($request->sub_cat)>0)){
                      // Creating multiple sub-categories
                    foreach ($request->sub_cat as $key => $value) {
                        $sub_category = Sub_category::create([
                            'name' => $value,
                            'cat_id' => $category->id
                        ]);
                    }
                }
              

            });

            if(is_null($exception)) {
                return response()->json(['success'=>$request['name']. ' added successfully.']);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong.',
                "data"      => $e
            ], 404);
        }
      
    } 

     public function show(Category $category)
    {
        $data         = Category::findorFail($category->id);
        return view('categories.show',compact('data'));
    }


    public function edit(Category $category)
    {
        $sub_category   = Category::findorFail($category->id)->subCategory()->get();
        $category       = Category::findorFail($category->id);
        return view('categories.edit',compact('sub_category','category'));

    }


    public function update(CategoryRequest $request,Category $category)
    {
        try {
            // Transaction
            $exception = DB::transaction(function() use ($request,$category){ 

                // Creating a single category
                $category               = Category::where('id',$category->id)->first();
                $category->name         = $request->name;
                $category->active       = $request->active;
                $category->created_by   = Auth::user()->id;
                $category->save();

                // Deleting all sub-categories first
                $sub_category   = Sub_category::where('cat_id',$category->id)->delete();

                // Creating new multiple sub-categories
                if ($sub_category) {
                    foreach ($request->sub_cat as $key => $value) {
                        $sub_cat = Sub_category::create([
                            'name' => $value,
                            'cat_id' => $category->id
                        ]);
                    }
                }

            });

            if(is_null($exception)) {
                return response()->json(['success'=>$request['name']. ' updated successfully.']);
            } else {
                throw new Exception;
            }
        }
        
        catch(\Exception $e) {
            app('App\Http\Controllers\MailController')->send_exception($e);
            return Response::json([
                'status'    => "failed",
                'msg'       => 'Something went wrong.',
                "data"      => $e
            ], 404);
        }
        
    }

    public function del_category(Category $category)
    {
        $data   = Category::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Category deleted successfully."]);
    }

}
