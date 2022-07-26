<?php

namespace App\Http\Controllers;
use DB;
use Response;
use App\Models\Message;
use App\Models\People;
use App\Events\MessageEvent;
use Illuminate\Http\Request;

use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    
    public function send_message(MessageRequest $request){
    	event(
                new MessageEvent(
                                    $request->input('message'),
                                    $request->input('sender_id'), 
                                    $request->input('receiver_id'), 
                )
            );

        $data         = Message::create($request->all());

        

        return Response::json([
            'status'        => "failed",
            'msg'           => "Message send successfully"
        ], 200);
    }

    public function get_captain_details($id){

        $details               =  People::where('people.id',$id)
                                    ->leftjoin('people_details', 'people_details.people_id', '=', 'people.id')
                                    ->select(
                                            'people.id as cap_id',
                                            'people.fname as cap_name',
                                            'people.contact_no as contact_no',
                                            DB::raw('(CASE 
                                                WHEN isNULL(people_details.profile_pic) THEN "public/uploads/no_image.png" 
                                                ELSE CONCAT("public/uploads/peoples/",people_details.profile_pic)
                                                END) AS profile_pic'
                                            ),

                                        )
                                    ->first();
                                            
        return $details;
                                            
    }

    public function get_recent_people(Request $request){

        $receivers              =  Message::where('messages.active',1)
                                        ->leftjoin('people', 'people.id', '=', 'messages.receiver_id')
                                        ->where('messages.sender_id',$request->people_id)
                                        ->select(
                                                'people.fname as name',
                                                'people.id as people_id',
                                                'messages.receiver_id as people'
                                            )
                                        ->distinct('messages.receiver_id')
                                        ->get();


        $senders              =  Message::where('messages.active',1)
                                        ->leftjoin('people', 'people.id', '=', 'messages.sender_id')
                                        ->where('messages.receiver_id',$request->people_id)
                                        ->select(
                                                'people.fname as name',
                                                'people.id as people_id',
                                                'messages.sender_id as people'
                                            )
                                        ->distinct('messages.sender_id')
                                        ->get();
                                            return $receivers->toArray();
                                            
        $array = array_merge($receivers->toArray(), $senders->toArray());
        return Response::json($array);
        // $data = $receivers->merge($senders);                  
        // return $data;


        // $senders              =  Message::where('messages.active',1)
        //                                 ->leftjoin('people', 'people.id', '=', 'messages.sender_id')
        //                                 ->where('messages.sender_id',$request->people_id)
        //                                 ->select(
        //                                         'people.fname as name',
        //                                         'people.id as people_id',
        //                                         'receiver_id as receiver'
        //                                     )
        //                                 ->get();
    }

    public function fetch_messages(Request $request)
    {

        //  receiver = captain
        $messages               =  Message::where('messages.active',1)
                                    ->orderBy('messages.created_at', 'desc')
                                    ->leftjoin('people', 'people.id', '=', 'messages.sender_id')
                                    ->where('messages.sender_id',$request->sender_id)->where('messages.receiver_id',$request->receiver_id)
                                    ->orWhere('messages.sender_id',$request->receiver_id)->where('messages.receiver_id',$request->sender_id)
                                    ->select(
                                            'people.fname as name',
                                            'messages.id as _id',
                                            'messages.message as text',
                                            'sender_id as sender',
                                            'receiver_id as receiver',
                                            'messages.created_at as createdAt',
                                        )
                                    ->get();

                                // $people_vehicles->push(((object) array("vehicle_id" => "0")))

        foreach ($messages as $key => $message) {
            $messages[$key]->user =((object) array(
                                                    "_id" => "$message->sender",
                                                    "avatar" => "https://placeimg.com/140/140/any",
                                                    "name" => $message->name,
                                                )); 
        }

        $details                = $this->get_captain_details($request->receiver_id);

        return Response::json([
                                'status'        => "success",
                                'msg'           => "People message fetched successfully",
                                'data'          => [
                                                        'people_messages' =>  $messages, 
                                                        'captain_details' =>  $details,
                                                ]
                            ], 200);
    }
}

