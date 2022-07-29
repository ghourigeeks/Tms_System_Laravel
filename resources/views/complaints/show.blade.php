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
                <div class="card p-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Show @yield('title')</h4>
                            <a  href="{{ route('complaints.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
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
                        {!! Form::open(array('id'=>'form','enctype'=>'multipart/form-data')) !!}
                        {{  Form::hidden('created_by', Auth::user()->id ) }}
                        {{  Form::hidden('action', "update" ) }}
                        <div class="card-body">
                            <div class=" row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('response','Response <span class="text-danger">*</span>')) !!}
                                        {{ Form::textarea('response', null, array('placeholder' => 'Enter response','class' => 'form-control','autofocus' => '', 'rows'=>4  )) }}
                                        @if ($errors->has('response'))  
                                            {!! "<span class='span_danger'>". $errors->first('response')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm mr-2">Save</button>
                                    <button type="reset" class="btn btn-danger  btn-sm ">Cancel</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!--end::Form-->
                    </div>
                    <div class="card-fooer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('complaints.update',$data->id) }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.success){
                        this.reset();
                        toastr.success(data.success);
                    }
                },
                error: function(data) {
                    var txt         = '';
                    console.log(data.responseJSON.errors[0])
                    for (var key in data.responseJSON.errors) {
                        txt += data.responseJSON.errors[key];
                        txt +='<br>';
                    }
                    toastr.error(txt);
                }
            });
        });

        $(".response-btn").click(function(){
            $(".response-form").slideToggle("medium");
        });
    });
</script>
    

@endsection
