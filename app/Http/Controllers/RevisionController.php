<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Revision;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\RevisionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\RevisionExport;
use Maatwebsite\Excel\Facades\Excel;

class RevisionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:revision-list', ['only' => ['index','show']]);
         $this->middleware('permission:revision-create', ['only' => ['create','store']]);
         $this->middleware('permission:revision-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:revision-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

            return view('revisions.index');
    }

    public function list()
    {
        if(Auth::user()->id == 1){
            $data   = Revision::orderBy('revisions.order_id')
                    ->select(
                                'revisions.id',
                                'revisions.user_id',
                                'revisions.order_id',
                                'revisions.complete',
                                'revisions.start_date',
                                'revisions.active'
                            )
                    ->get();
            }else{
                $data   = Revision::orderBy('revisions.order_id')
                ->where('revisions.user_id', Auth::user()->id )
                    ->select(
                                'revisions.id',
                                'revisions.user_id',
                                'revisions.order_id',
                                'revisions.complete',
                                'revisions.start_date',
                                'revisions.active'
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
                ->addColumn('order_name',function($data){
                    if(isset($data->order->name)){
                        return $data->order->name;
                    }else{
                        return "";
                    }
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="revisions/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="revisions/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_revision') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','user_name','order_name','','action'])
                ->make(true);
    }

    public function create()
    {
        $user     = User::pluck('name','id')->all();
        $order    = Order::pluck('name','id')->all();
        $user_id  = Auth::user()->id;
        return view('revisions.create', compact('user','user_id','order'));
    }

    public function store(RevisionRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Revision::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
      
    }

     public function show($id)
    {
        $data         = Revision::findorFail($id);
        return view('revisions.show',compact('data'));
    }


    public function edit($id)
    {
        $data           = Revision::findorFail($id);
        $user           = User::pluck('name','id')->all();
        $user_id        = User::select('id')->where('id',$data->user_id)->first();
        $order          = Order::pluck('name','id')->all();
        $order_id       = Order::select('id')->where('id',$data->order_id)->first();

        // dd($data);
        return view('revisions.edit',compact('data','user','user_id','order','order_id'));
    }


    public function update(RevisionRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Revision::findOrFail($id);
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
        $data   = Revision::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Revision deleted successfully."]);
    }

    public function get_revision_data()
    {
        return Excel::download(new RevisionExport, 'revisions.xlsx');
    }

}
