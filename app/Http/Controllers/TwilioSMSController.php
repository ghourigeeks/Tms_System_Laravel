<?php
  
namespace App\Http\Controllers;
  
use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
  
class TwilioSMSController extends Controller
{
    
    public function index($contact_no, $code)
    {
        $receiverNumber     = $contact_no;
        $message            = "Your OTP ". $code;
  
        try {
  
            $account_sid    = getenv("TWILIO_SID");
            $auth_token     = getenv("TWILIO_TOKEN");
            $twilio_number  = getenv("TWILIO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                                        'from' => $twilio_number, 
                                        'body' => $message
                                    ]);
  
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
            return false;

        }
        return true;
    }
}