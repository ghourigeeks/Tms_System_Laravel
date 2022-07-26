<?php

namespace App\Http\Controllers;

use Response;
use App\Events\Message;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    
    public function message(Request $request){
        
    	event(new Message($request->input('username'), $request->input('message')));
        return Response::json([
            'status'        => "success",
            'msg'           => "Message send successfully"
        ], 200);
    }
}

