@extends('layouts.main')
@section('title','Faq')
@section('content')

    @include( '../sweet_script')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add @yield('title')</h4><span style="margin-left:10px" class="loader"></span>
                            <a  href="{{ route('faqs.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    {!! Form::open(array('id'=>'form','enctype'=>'multipart/form-data')) !!}
                        {{  Form::hidden('created_by', Auth::user()->id ) }}
                        {{  Form::hidden('action', "store" ) }}
                        <div class="card-body">
                            <div class=" row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('question','Question <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('question', null, array('placeholder' => 'Enter question','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('question'))  
                                            {!! "<span class='span_danger'>". $errors->first('question')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class=" row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('description','Description <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('description', null, array('placeholder' => 'Enter description','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('description'))  
                                            {!! "<span class='span_danger'>". $errors->first('description')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button id="aaa" type="submit" class="btn btn-primary btn-sm mr-2">Save</button>
                                    <button type="reset" class="btn btn-danger  btn-sm ">Cancel</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!--end::Form-->
                    
                </div>
            </div>
        </div>
    </div>
    
    <script>
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
                    url: "{{ route('faqs.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('.loader').show();
                    },
                    success: (data) => {
                        if(data.success){
                            this.reset();
                            toastr.success(data.success);
                            $('.loader').hide();
                        }
                    },
                    error: function(data) {
                        var txt         = '';
                        console.log(data.responseJSON.errors[0])
                        for (var key in data.responseJSON.errors) {
                            txt += data.responseJSON.errors[key];
                            txt +='<br>';
                        }
                        $('.loader').hide();
                        toastr.error(txt);
                    }
                });
            });
        });
    </script>

@endsection