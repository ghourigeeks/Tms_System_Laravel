<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Mail;
use Exception;
class MailController extends Controller {

    public function send_exception($e)
    {
        $exception          = array();
        $exception['line']  = $e->getLine();
        $exception['file']  = $e->getFile();
        $exception['msg']   = $e->getMessage();
     
      
        try {

            $emails = env("DEVELOPER_EMAIL");

            // return view('mails.exception',
            // compact('exception'
            //     )
            // );
            // dd($emails);

            $data       = array(
                "exception"                  => $exception,
            );
            
            Mail::send('mails.exception', $data, function($message) use ($emails) {
                $message->from(env("MAIL_FROM_ADDRESS"),'Highway');
                $message->to($emails)->subject('Exception');
                // var_dump( Mail:: failures());
            });

        }catch (Exception $e) {
            // echo $e;
            return 0;
        }
    }
    
     public function send_test($email) {

        $to_name    = $orders->customer_name;
        $to_email   = $email;
        $data       = array("data" => "test---test");

        try {
            if(filter_var($to_email, FILTER_VALIDATE_EMAIL) === FALSE) {
                throw new Exception("$to_email is not valid email");
            }

            Mail::send('mails.test', $data, function($message) use ($to_email) {
                        $message->from("info@washup.com.pk",'Washup');
                        $message->to($to_email, "test-name")->subject('Updated Invoice');
                    });
        }catch (Exception $e) {
            echo $e;
            return 0;
        }

        return 1;
    }
}
