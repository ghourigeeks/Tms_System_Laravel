<?php


namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function connection($record){

        $ch             = curl_init();
        $record         = http_build_query($record);
        $url            = "http://Bsms.its.com.pk/api.php?key=9f77fe75fea7771ae3b311a64b840c66";
        $getUrl         = $url."&".$record;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response       = curl_exec($ch);

        if(curl_error($ch)){
            echo 'Request Error:' . curl_error($ch);
            curl_close($ch);
            // return curl_error($ch);
            return false;
        }else{
            curl_close($ch);
            // echo $response;
            return true;
        }
       
        
    }

   // Dummy msg for testing purpose
    public function send_otp($contact_no,$otp){
        // $contact_no     = "03139120034";
        $record      = array(
            "receiver"  => $contact_no,
            "msgdata"   => ("Automated-Pin : " . $otp),
            "sender"    => "WASHUP"
        );

        return $this->connection($record);
    }


    

    
}
