<?php

namespace App\Http\Controllers;

use DB;
use Str;
use DataTables;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Requests\FaqRequest;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:faq-list', ['only' => ['index','show']]);
         $this->middleware('permission:faq-create', ['only' => ['create','store']]);
         $this->middleware('permission:faq-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('faqs.index');
    }

    public function list()
    {
        $data   = Faq::orderBy('faqs.question')
                    ->select(
                                'faqs.id',
                                'faqs.question',
                                'faqs.description',
                                'faqs.active',
                            )
                    ->get();
        return 
            DataTables::of($data)
                ->addColumn('question',function($data){
                    return (isset($data->question)) ? (Str::of($data->question)->limit(30)) : "";
                })
                ->addColumn('description',function($data){
                    return (isset($data->description)) ? (Str::of($data->description)->limit(30)) : "";
                })
                ->addColumn('action',function($data){
                    return '
                    <div class="btn-group btn-group">
                        <a class="btn btn-info btn-xs" href="faqs/'.$data->id.'">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-info btn-xs" href="faqs/'.$data->id.'/edit" id="'.$data->id.'">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <button
                            class="btn btn-danger btn-xs delete_all"
                            data-url="'. url('del_faq') .'" data-id="'.$data->id.'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>';
                })
                ->addColumn('srno','')
                ->rawColumns(['srno','','action'])
                ->make(true);
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(FaqRequest $request)
    {
        // Retrieve the validated input data...
        $validated    = $request->validated();

        // store validated data
        $data         = Faq::create($request->all());
        return response()->json(['success'=>$request['name']. ' added successfully.']);
    }

    public function show($id)
    {
        $data         = Faq::findorFail($id);
        return view('faqs.show',compact('data'));
    }

    public function edit($id)
    {
        $data         = Faq::findorFail($id);
        return view('faqs.edit',compact('data'));
    }

    public function update(FaqRequest $request, $id)
    {
        // Retrieve the validated input data...
        $validated  = $request->validated();

        // get all request
        $data       = Faq::findOrFail($id);
        $input      = $request->all();

        // if active is not set, make it in-active

        if(!(isset($input['active']))){
            $input['active'] = 0;
        }

        // update
        $upd        = $data->update($input);
        return response()->json(['success'=>$request['name']. ' updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $data   = Faq::whereIn('id',explode(",", $request->ids))->delete();
        return response()->json(['success'=>$data." Faq deleted successfully."]);
    }
}
