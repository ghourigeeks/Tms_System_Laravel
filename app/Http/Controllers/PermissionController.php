<?php
namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:permission-list', ['only' => ['index','show']]);
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('permissions.index');
    }

    public function list()
    {
        $data   = Permission::orderBy('permissions.name')
                    ->select('permissions.id','permissions.name')
                    ->get();
                    
        return DataTables::of($data)
                ->addColumn('action',function($data){
                 return 
                        '<div class="btn-group btn-group">
                        </div>';
                    })
                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);

    }
       

    public function create()
    {
        return redirect()->route('permissions.index');
        // return view('permissions.create');
    }


    public function store(Request $request)
    {
        return redirect()->route('permissions.index');

        request()->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        Permission::create($request->all());
        return redirect()->route('permissions.create')
                        ->with('success','Permission '.$request['name']. ' added successfully.');
    }

    public function show(Permission $permission)
    {
        return redirect()->route('permissions.index');
        
        return view('permissions.show',compact('permission'));
    }


    public function edit(Permission $permission)
    {
        return redirect()->route('permissions.index');
        return view('permissions.edit',compact('permission'));
    }


    public function update(Request $request,$id)
    {
        return redirect()->route('permissions.index');
        $permission = Permission::findOrFail($id);
        request()->validate([
            'name' => 'required|unique:permissions,name,'. $id,
        ]);

        $permission->update($request->all());
        return redirect()->route('permissions.index')
                        ->with('success','Permission '.$request['name']. ' updated successfully');
    }

    public function destroy(Permission $permission)
    {
        return redirect()->route('permissions.index');
        $ids = $request->ids;
        $data = Permission::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>$data." Permission deleted successfully."]);
    }

   
}
