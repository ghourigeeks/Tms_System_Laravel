<?php
namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use DataTables;
use App\Models\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit|user-profileEdit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
         // $this->middleware('permission:user-profileEdit', ['only' => ['profileedit','update']]);
    }

    public function index(Request $request)
    {
        return view('users.index');
    }

    public function list()
    {
        $data   = User::orderBy('name')
                    ->leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select(
                                'users.id',
                                'users.name',
                                'users.email',
                                'users.last_seen',
                                'users.active',
                                'roles.name as rolename',
                            )
                    ->get();

         return 
            DataTables::of($data)
                ->addColumn('lastseen',function($data){
                    if(Cache::has('is_online' . $data->id)){
                        return "Online";
                    }else{
                        return "Offline";
                    }
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-dark btn-xs" href="users/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-dark btn-xs" href="users/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_user') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','lastseen','','action'])
                ->make(true);

    }
    public function create()
    {
        $roles  = Role::where('id','!=',1)->pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // get all request
        $input       = $request->all();

        // uploading image
        if(isset($request['profile_pic'])){
            $image                  = $request->file('profile_pic');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                        $image->move(public_path("uploads/users"),$new_name);
            $input['profile_pic']   = $new_name;
        }

        // creating encrypted password
        $input['password']          = Hash::make($input['password']);

        // store new entity
        $data                       = User::create($input);
        
        // assign role 
        $data->assignRole($request->input('roles'));

        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    public function show($id)
    {
        $data           = DB::table('users')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.*','roles.name as rn')
                            ->where('users.id', $id)
                            ->first();
      
        return view('users.show',compact('data'));
    }

    public function profileedit($id)
    {
        $user           = User::find($id);
        $roles          = Role::pluck('name','name')->all();
        $userRole       = $user->roles->pluck('name','name')->all();
        $designations   = Designation::pluck('name','id')->all();

        return view('profile.edit',compact('user','roles','userRole','designations'));
    }

    public function profileShow($id)
    {
        $user           = DB::table('users')
                            ->join('designations', 'designations.id', '=', 'users.designation_id')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.id','users.name as un','users.username','users.email','users.proImage','designations.name as dn','roles.name as rn','users.created_at','users.updated_at')
                            ->where('users.id', $id)
                            ->first();
        return view('profile.show',compact('user'));
    }

    public function edit($id)
    {
        $data           = User::findorFail($id);
        $roles          = array();
   
        if($id == 1){       // user id = 1 ==> Super Admin
            $roles      = Role::pluck('name','name')->all();
        }else{
            $roles      = Role::where('id','!=',1)->pluck('name','name')->all();
            $userRoleId = $data->roles->pluck('id')->first();

            if($userRoleId !=2){  // role id = 2 ==> Admin
                $roles      = Role::where('id',$userRoleId)->pluck('name','name')->all();
            }

        }
        
   
        $userRole        = $data->roles->pluck('name','name')->all();

        return view('users.edit',compact('data','roles','userRole'));
    }


    public function update(UserRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = User::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active
        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // password 
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input['password'] = $data['password'];
        }

        // image
        if(!empty($input['profile_pic'])){
            // $this->validate($request,['profile_pic'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
            // delete the previous image
            if($data['profile_pic']!=""){
                unlink(public_path('uploads/users/'.$data['profile_pic']));
            }

            // upload the new image
            $image                  = $request->file('profile_pic');
            $new_name               = rand().'.'.$image->getClientOriginalExtension();
                                      $image->move(public_path("uploads/users"),$new_name);
            $input['profile_pic']   = $new_name;
        }else{
            $input['profile_pic']   = $data['profile_pic'];
        }

        // update the entity
        $data->update($input);

        // delete previous roles
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        // assign new roles
        $data->assignRole($request->input('roles'));

        return response()->json(['success'=>$input['name']. ' updated successfully.']);
    }


    public function destroy(Request $request)
    { 

        if($request->ids == 1){
            return response()->json(['error'=> 'This is Super-Admin and cannot be deleted']);
        }
        $ids        = $request->ids;
        $checkId    = Auth::user()->id;

        if($checkId == $ids){
            return response()->json(['error'=> 'This is logged in user, cannot be deleted']);
        }else{
            $user = User::find($ids);
             if($user['image']!=""){
                unlink(public_path('uploads/users/'.$user['image']));
            }
            $data = User::whereIn('id',explode(",",$ids))->delete();
            return response()->json(['success'=>$data." User deleted successfully."]);
        }
    }
}
