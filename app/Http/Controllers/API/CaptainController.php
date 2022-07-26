<?php
namespace App\Http\Controllers\API;

use DB;
use Response;
use Validator;
use App\Models\City;
use App\Models\Captain;
use Illuminate\Http\Request;
use App\Models\Captain_schedule;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaptainRequest;

class CaptainController extends Controller
{
    function login(Request $request)
    {
        $record     = Captain::where('username', $request->username)->first();
       
        if ( (empty($record)) || !(Hash::check($request->password, $record->password))) {
            return Response::json([
                                    'status'    => "failed",
                                    'error'     => 'Incorrect Credentials!',
                                ], 404);
        }
    
        // delete all previous tokens of this ID
        $record->tokens()
                ->where('tokenable_id', $record->id)
                ->where('name', 'captain-token')
                ->delete();

        // create new token for this ID
        $token              = $record->createToken('captain-token')->plainTextToken;
    
        return Response::json([
                                'status'        => "success",
                                'token'         => $token,
                                'username'      => $record->username,
                                'captain_id'    => $record->id
                            ], 200);
    }

    public function register(Request $request)
    {
        $validator              = Validator::make($request->all(),
            [
                // 'contact_no'    => 'required|unique:captains,contact_no|digits:11|numeric',
                // 'email'         => 'email|unique:captains,email',
                'fname'         => 'required|min:3|regex:/^([^0-9]*)$/',
                'cnic'          => 'required|unique:captains,cnic|digits:13|numeric',
                'username'      => 'required|min:3|unique:captains,username',
                'password'      => 'required|min:8'
            ],
            [
                'fname.regex'   => 'Special characters and numbers are not allowed!',
            ]
        );

        if (!($validator->passes())) {
            return Response::json([
                                    'status'    => "failed",
                                    'error'     => $validator->errors()->all(),
                                ], 404);
        }

        // get all request
        $request->fname      = ucwords($request->fname);
        $input               = $request->all();

        // creating encrypted password
        $input['password']   = Hash::make($input['password']);
        $record              = Captain::create($input);

        // create new token for this ID
        $token              = $record->createToken('captain-token')->plainTextToken;

        return Response::json([
                                'status'        => "success",
                                'token'         => $token,
                                'username'      => $record->username,
                                'captain_id'    => $record->id
                            ], 200);
       
    }
    
    public function cities(){
        $record   = City::select('id','name','lat','lng')->where('active',1)->get()->toArray();
        return Response::json([
                                'status'        => "success",
                                'data'          => $record
                            ], 200);
    }
    
    public function charts($id){
        $data      = [];
        // 1: Scheduled
        // 4: Completed
        // 5: Cancelled
        $scheduled  = Captain_schedule::where('captain_id', $id)->where('status_id', 1)->count();
        $completed  = Captain_schedule::where('captain_id', $id)->where('status_id', 4)->count();
        $cancelled  = Captain_schedule::where('captain_id', $id)->where('status_id', 5)->count();

        $data[]    = [
                        'name' => 'Scheduled',
                        'drives' => $scheduled
                    ];
                    
        $data[]    = [
                        'name' => 'Completed',
                        'drives' => $completed
                    ];
                    
        $data[]    = [
                        'name' => 'Cancelled',
                        'drives' => $cancelled
                    ];
                    
        
      return Response::json([
                                'status'  => "success",
                                'data'    => $data
                            ], 200);
        
    }

    public function logout(){
        $record         = request()->user(); 
       
        if($record){

            // Revoke current user token
            $record->tokens()->where('id', $record->currentAccessToken()->id)->delete();
            return Response::json([
                                    'status'  => "success",
                                    'data'   => "logout successfully"
                                ], 200);
        }else{
            return Response::json([
                                    'status'    => "failed",
                                    'error'     => 'token not found',
                                ], 404);
        }
    }

    public function forgot(Request $request){

        $validator      = Validator::make($request->all(), ['username' => 'required']);

        if (!($validator->passes())) {
            return Response::json([
                                    'status'        => "failed",
                                    'error'         => $validator->errors()->all()
                                ], 404);
        }

        $record         = Captain::where('username', $request->username)->update(['forgot' => '1']);
        if($record){
            return Response::json(['status'  => "success"], 200);
        }else{
            return Response::json([
                                    'status'        => "failed",
                                    'error'         => "username not found!"
                                ], 404);
        }
       
       
    }
}


