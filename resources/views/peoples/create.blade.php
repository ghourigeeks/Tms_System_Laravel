@extends('layouts.main')
@section('title','People')
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
                            <h4 class="card-title">Add @yield('title')</h4>
                            <a  href="{{ route('peoples.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            
                        </div>
                    </div>

                        <!--begin::Form-->
                        {!! Form::open(array('id'=>'form','enctype'=>'multipart/form-data')) !!}
                            {{  Form::hidden('created_by', Auth::user()->id ) }}
                            {{  Form::hidden('action', "store" ) }}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('fname','Full name <span class="text-danger">*</span>')) !!}
                                            {{ Form::text('fname', null, array('placeholder' => 'Enter full name','class' => 'form-control','autofocus' => '', 'required'=>''  )) }}
                                            @if ($errors->has('fname'))  
                                                {!! "<span class='span_danger'>". $errors->first('fname')."</span>"!!} 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('contact_no','Contact# <span class="text-danger">*</span>')) !!}
                                            {!! Form::text('contact_no', null, array('placeholder' => 'Enter contact#','class' => 'form-control','required'=>'')) !!}
                                            @if ($errors->has('contact_no'))  
                                                {!! "<span class='span_danger'>". $errors->first('contact_no')."</span>"!!} 
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            {!! Html::decode(Form::label('password','Password <span class="text-danger">*</span>')) !!}
                                            {!! Form::password('password', array('placeholder' => 'Enter password','class' => 'form-control')) !!}
                                            @if ($errors->has('password'))  
                                                {!! "<span class='span_danger'>". $errors->first('password')."</span>"!!} 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                               
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button type="submit" class="btn btn-primary mr-2  btn-sm">Save</button>
                                        <button type="reset" class="btn btn-danger  btn-sm">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <!--end::Form-->
                    </div>
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
                    url: "{{ route('peoples.store') }}",
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
                        // console.log(data.responseJSON.errors[0])
                        for (var key in data.responseJSON.errors) {
                            txt += data.responseJSON.errors[key];
                            txt +='<br>';
                        }
                        toastr.error(txt);
                    }
                });
            });
        });
    </script>

@endsection
