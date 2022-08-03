<?php
namespace App\Http\Controllers\API;

use DB;
use Response;
use Validator;
use Exception;

use Illuminate\Http\Request;
use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\Client;
use App\Models\Payment_method;
use App\Models\People;
use App\Models\Client_package;
use App\Http\Controllers\Controller;

use App\Http\Controllers\TwilioSMSController;
use App\Http\Controllers\NotificationController;

class MainController extends Controller
{

    public function returnResponse($status,$msg,$data, $code){
        return Response::json([
            'status'    => $status,
            'msg'       => $msg,
            "data"      => $data
        ], $code);
    }
   
    public function signUp(MainRequest $request)
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "signUp")) ){
            return $this->returnResponse("failed","Action not matched!",[], 404);
        }
        
        $req               = $request->all();
        $req['fullname']   = ucwords($req['fullname']);
        $req['password']   = Hash::make($req['password']);
        $record            = Client::create($req);
        
        return $this->returnResponse("success","Client created successfully!",[], 200);
    }

    public function signIn(MainRequest $request)
    {

        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "signIn")) ){
            return $this->returnResponse("failed","Action not matched!",[], 404);
        }

        $record             = Client::where('email', $request->email)->first();

        // is user exist
        if(empty($record)){
            return $this->returnResponse("failed","Couldn't find your Account!",[], 404);
        }

        // checking password
        if(!(Hash::check($request->password, $record->password))) {
            return $this->returnResponse("failed","Invalid password!",[], 404);
        }

        $data               = array();
        $data['token']      = $record->createToken('client-token')->plainTextToken;;
        $data['email']      = ((isset($record->email)) ? ($record->email) : "");
        $data['fullname']   = ((isset($record->fullname)) ? ($record->fullname) : "");
        $data['username']   = ((isset($record->username)) ? ($record->username) : "");
        $data['phone_no']   = ((isset($record->phone_no)) ? ($record->phone_no) : "");
        $data['profile_pic']= $record->profile_pic;
        $data['is_new']     = (empty(Client_package::where('client_id', $record->id)->first())) ? true : false;
        return $this->returnResponse("success","Logged in successfully!",$data, 200);
    }

    public function forgot(MainRequest $request)
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "forgot")) ){
            return $this->returnResponse();
        }
        $record             = Client::where('email', $request->email)->first();
        if ( empty($record)){
            return $this->returnResponse("failed","Couldn't find your Account!",[], 404);
        }

       // otp will be sent to non-verified user.
       $input['temp_code']  = rand(1000000000, 9999999999);
       $input['forgot']     = 1;
                              $record->update($input);

        return $this->returnResponse("success","Passcode sent to email!",[], 200);

    }

    public function resetPassword(MainRequest $request)
    {
        $record         = People::where('temp_code', $request->temp_code)
                            ->whereNotNull('forgot')
                            ->first();

        if ( empty($record)){
            return $this->returnResponse("failed","Invalid Passcode!",[], 404);
        }
            

        $req               = $request->all();
        $req['forgot']     = null;
        $req['temp_code']  = null;
        $req['password']   = Hash::make($req['password']);

        $record->update($input);
        return $this->returnResponse("success","Password reset successfully!",[], 200);
    }

    public function fetchPaymentMethods(){
        $data               = Payment_method::get();
        return $this->returnResponse("success","Payment methods fetched successfully!",$data, 200);
    }

    
    
    public function logout()
    {
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
                                    'msg'       => 'token not found',
                                ], 404);
        }
    }
}


