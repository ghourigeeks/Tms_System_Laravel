<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Requests\ratingRequest;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:rating-list', ['only' => ['index','show']]);
         $this->middleware('permission:rating-create', ['only' => ['create','store']]);
         $this->middleware('permission:rating-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:rating-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('ratings.index');
    }

    public function list()
    {
        $data   = Rating::orderBy('ratings.name')
                    ->select(
                                'ratings.id',
                                'ratings.name',
                                'ratings.active'
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="ratings/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="ratings/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_rating') .'" data-id="'.$data->id.'">
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
        return view('ratings.create');
    }

    public function store(RatingRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Rating::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Rating::findorFail($id);
        return view('ratings.show',compact('data'));
    }


    public function edit($id)
    {
        $data         = Rating::findorFail($id);
        return view('ratings.edit',compact('data'));
    }


    public function update(RatingRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Rating::findOrFail($id);
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
        $data   = Rating::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." rating deleted successfully."]);
    }

}
