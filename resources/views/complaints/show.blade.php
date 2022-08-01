@extends('layouts.main')
@section('title','Complaint')
@section('content')
    @include( '../sweet_script')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
<<<<<<< Updated upstream
                <div class="card p-4">
=======
                <div class="card">
>>>>>>> Stashed changes
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Show @yield('title')</h4>
                            <a  href="{{ route('complaints.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
<<<<<<< Updated upstream
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="invoice-header row">
                                    <div class="invoice-title col-md-10">
                                        <h4><b>From:</b> {{$data->clients->fullname}}</h4>
                                    </div>
                                    <div class="invoice-logo col-md-2">
                                        <img src="{{$data->clients->profile_pic}}" width="90px" alt="company logo">
                                    </div>
                                </div>
                                <div class="invoice-desc mt-3">
                                    <h4><b>Email:</b> {{$data->clients->email}}</h4>
                                    <h4><b>Date:</b> {{$data->created_at}}</h4>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                       <h4><b>Subject:</b> {{$data->subject}}</h4>
                                    </div>
                                </div>
                                <div class="separator-solid mb-0"></div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h4 class="sub"><b>Complaint:</b> {{$data->complaint}}</h4>
                                        <div class="pull-right">
                                            @if($data->res == null || $data->res == "")
                                                <a class="text-light btn btn-warning btn-sm">Pending</a>
                                            @else
                                                <a class="text-light btn btn-success btn-sm">responded</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="pull-right">
                            @if($data->res == null || $data->res == "")
                                <a class="text-light btn btn-primary btn-sm response-btn">Response</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card response-form">
                    <div class="card-header">
                       <!--begin::Form-->
                     <form action="{{ route('complaints.update',$data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                             <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('res','Response <span class="text-danger">*</span>')) !!}
                                        {{ Form::textarea('res', null, array('placeholder' => 'Enter response','class' => 'form-control','autofocus' => '', 'rows'=>4  )) }}
                                        @if ($errors->has('res'))  
                                        {!! "<span class='span_danger'>". $errors->first('res')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    <!--end::Form-->
                    </div>
                    <div class="card-fooer"></div>
=======
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="table-responsive">
                                <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Client</th>
                                                <td>{{ isset($data->client->fullname) ? ($data->client->fullname) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Subject</th>
                                                <td>{{$data->subject}}</td>
                                            </tr>

                                            <tr>
                                                <th>Complaint</th>
                                                <td>{{ isset($data->complaint) ? ($data->complaint) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <th>Response/ reply</th>
                                                <td>{{ isset($data->res) ? ($data->res) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="ml-auto">
                                                        @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>


                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
>>>>>>> Stashed changes
                </div>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $(".response-btn").click(function(){
            $(".response-form").slideToggle("medium");
        });
    });
</script>
=======
>>>>>>> Stashed changes
    

@endsection
