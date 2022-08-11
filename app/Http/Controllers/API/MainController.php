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
use App\Models\Box;
use App\Models\Product;
use App\Models\Ibeacon;
use App\Models\Payment_method;
use App\Models\Package;
use App\Models\Client_package;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Region;
use App\Models\Category;
use App\Models\Sub_category;
use App\Http\Controllers\TwilioSMSController;
use App\Http\Controllers\NotificationController;



class MainController extends Controller
{

    public function returnResponse($status,$msg,$data, $code)
    {
        return Response::json([
            'status'    => $status,
            'msg'       => $msg,
            "data"      => $data
        ], $code);
    }
   
    public function signUp(MainRequest $request)
    {
        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "signUp")) ){
            return $this->returnResponse("failed","Action not matched!",null, 404);
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
            return $this->returnResponse("failed","Action not matched!",null, 404);
        }

        $record             = Client::where('email', $request->email)->first();

        // is user exist
        if(empty($record)){
            return $this->returnResponse("failed","Couldn't find your Account!",null, 404);
        }

        // checking password
        if(!(Hash::check($request->password, $record->password))) {
            return $this->returnResponse("failed","Invalid password!",null, 404);
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
            return $this->returnResponse("failed","Couldn't find your Account!",null, 404);
        }

       // otp will be sent to non-verified user.
       $input['temp_code']  = rand(1000000000, 9999999999);
       $input['forgot']     = 1;
                              $record->update($input);

        return $this->returnResponse("success","Passcode sent to email!",[], 200);

    }

    public function resetPassword(MainRequest $request)
    {
        $record         = Client::where('temp_code', $request->temp_code)
                            ->whereNotNull('forgot')
                            ->first();

        if ( empty($record)){
            return $this->returnResponse("failed","Invalid Passcode!",null, 404);
        }
            
        $req               = $request->all();
        $req['forgot']     = null;
        $req['temp_code']  = null;
        $req['password']   = Hash::make($req['password']);

        $record->update($input);
        return $this->returnResponse("success","Password reset successfully!",[], 200);
    }

    public function fetchPaymentMethods()
    {
        $data               = Payment_method::select('id','name')->get();
        return $this->returnResponse("success","Payment methods fetched successfully!",$data, 200);
    }

    public function fetchPackages()
    {
        $data               = Package::select(
                                                'id',
                                                'name',
                                                'amount',
                                                'box_limit',
                                                'inventory_limit',
                                                'add_to_mp',
                                                'ibeacon',
                                                'barcode',
                                                'qrcode'
                                            )
                                    ->get();
        return $this->returnResponse("success","Packages fetched successfully!",$data, 200);
    }

    public function fetchProfile($client_id)
    {
        $regions            = Region::select('id as region_id','name as region_name')->get();
        $countries          = Country::select('id as country_id','name as country_name','region_id')->get();
        
        $client             = Client::select(
                                                'id',
                                                'fullname',
                                                'username',
                                                'email',
                                                'phone_no',
                                                'password',
                                                'address',
                                                'region_id',
                                                'country_id',
                                                'state',
                                                'city',
                                                'profile_pic'
                                            )
                                    ->where('id',$client_id)
                                    ->first();
        if ( empty($client)){
            return $this->returnResponse("failed","No client found!",null, 404);
        }
        $data['profile']    = $client;
        $data['regions']    = $regions;
        $data['countries']  = $countries;
        
     
        return $this->returnResponse("success","Client profile fetched successfully!",$data, 200);
    }

    public function updateProfile(MainRequest $request)
    {

        if( (!(isset( $request->action ))) || ((isset( $request->action )) && ( $request->action != "updateProfile")) ){
            return $this->returnResponse("failed","Action not matched!",null, 404);
        }
        
        $record         = Client::where('id', $request->client_id)->first();

        if ( empty($record)){
            return $this->returnResponse("failed","No client found!",null, 404);
        }

        $req               = $request->all();
        $req['fullname']   = ucwords($req['fullname']);
        $req['password']   = ( isset($req['password']) ?(Hash::make($req['password'])) : ($record->password) );
        $req['forgot']     = null;
        $req['temp_code']  = null;

        // BEING :: uploading image
        if( (array_key_exists("profile_pic",$req)) && (!empty($req['profile_pic']))  ){
        
            // delete the previous image
            if(isset($record->profile_pic)){
                if (file_exists( public_path('uploads/clients/'.$record->profile_pic) )){
                    unlink(public_path('uploads/clients/'.$record->profile_pic));
                }
            }

            $image                  = $request->file('profile_pic');
            $req['profile_pic']     = rand().'.'.$image->getClientOriginalExtension();
                                      $image->move(public_path("uploads/clients"),$req['profile_pic']);
        }
        // END:: uploading image

        $record->update($req);

        return $this->returnResponse("success","Profile updated successfully!",$record, 200);
    }

    public function fetchDashboard($client_id)
    {
        $client             = Client::where('id',$client_id)
                                ->first();
        if ( empty($client) ){
            return $this->returnResponse("failed","No client found!",null, 404);
        }

        $products           = Product::select('id','name','price','description')
                                ->where('client_id',$client_id)
                                ->get();

        $ibeacons           = Ibeacon::select('id','serial_no','box_id')
                                ->where('client_id',$client_id)
                                ->get();

        $tot_boxes          = Box::where('client_id',$client_id)
                                ->count();

        $tot_products       = Product::where('client_id',$client_id)
                                ->count();

        $tot_mp_products    = Product::where('client_id',$client_id)
                                ->where('added_to_mp',1)
                                ->count();

        // share feature not completed
        $tot_share_products = Product::where('client_id',$client_id)
                                ->whereNull('added_to_mp')
                                ->orWhere('added_to_mp',0)
                                ->count();
        
      
        if(! (empty($ibeacons )) ){
            foreach ($ibeacons as $key => $ibeacon) {
                $ibeacons[$key]->box_name = isset($ibeacon->box->name) ? $ibeacon->box->name : null;
            }
        }

        if(! (empty($products )) ){
            foreach ($products as $key => $product) {
                $products[$key]->product = isset($product->productImages[0]->pic) ? $product->productImages[0]->pic : null;
            }
        }

       
        $data['products']           = $products;
        $data['ibeacons']           = $ibeacons;
        $data['tot_boxes']          = $tot_boxes;
        $data['tot_products']       = $tot_products;
        $data['tot_mp_products']    = $tot_mp_products;
        $data['tot_share_products'] = $tot_share_products;
        return $this->returnResponse("success","Client profile fetched successfully!",$data, 200);
    }

    public function fetchCategory()
    {
        $data      = Category::select('id','name')
                        ->get();
        
        if ( empty($data)){
            return $this->returnResponse("failed","No categories found!",null, 404);
        }
     
        return $this->returnResponse("success","Categories fetched successfully!",$data, 200);
    }

    public function fetchSubCategory($cat_id)
    {
        $data      = Sub_category::select('id','name')
                        ->where('cat_id', $cat_id)
                        ->get();
        
        if ( empty($data)){
            return $this->returnResponse("failed","No sub categories found!",null, 404);
        }
     
        return $this->returnResponse("success","Sub categories fetched successfully!",$data, 200);
    }


    
    public function logout()
    {
        $record         = request()->user(); 
       
        if($record){

            // Revoke current user token
            $record->tokens()->where('id', $record->currentAccessToken()->id)->delete();
            return $this->returnResponse("success","logout successfully!",null, 200);
        }else{
            return $this->returnResponse("failed","token not found!",null, 404);
          
        }
    }
}


