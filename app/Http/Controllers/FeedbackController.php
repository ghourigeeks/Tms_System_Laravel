<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:feedback-list', ['only' => ['index','show']]);
         $this->middleware('permission:feedback-create', ['only' => ['create','store']]);
         $this->middleware('permission:feedback-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:feedback-delete', ['only' => ['destroy']]);
    }

    public function create()
    {
        return view('feedbacks.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'feedback' => 'required',
        ]);
        // store validated data
        $data         = Feedback::create($request->all());
        return response()->json(['success'=>$request['feedback']. ' added successfully.']);
      
    }
}
