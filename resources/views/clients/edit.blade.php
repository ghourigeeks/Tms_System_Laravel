@extends('layouts.main')
@section('title','Client')
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
                        <h4 class="card-title">Edit @yield('title')</h4>
                        <a  href="{{ route('clients.index') }}" class="btn btn-primary btn-xs ml-auto">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        
                    </div>
                </div>
                    <!--begin::Form-->
                    {!! Form::model($data, ['method' => 'PATCH','id'=>'form','enctype'=>'multipart/form-data']) !!}
                        {{  Form::hidden('updated_by', Auth::user()->id ) }}
                        {{  Form::hidden('action', "update" ) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('fname','Full name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('fullname', null, array('placeholder' => 'Enter full name','class' => 'form-control','autofocus' => '', 'required'=>''  )) }}
                                        @if ($errors->has('fullname'))  
                                            {!! "<span class='span_danger'>". $errors->first('fullname')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('active','Active<span class="text-danger">*</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->active == "Active") || ($data->active == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('active',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('active'))  
                                            {!! "<span class='span_danger'>". $errors->first('active')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('phone_no','Contact# <span class="text-danger">*</span>')) !!}
                                        {!! Form::text('phone_no', null, array('placeholder' => 'Enter contact#','class' => 'form-control','required'=>'')) !!}
                                        @if ($errors->has('phone_no'))  
                                            {!! "<span class='span_danger'>". $errors->first('phone_no')."</span>"!!} 
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
                                    <button type="reset" class="btn btn-danger btn-sm">Cancel</button>
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

        // getting and viewing images
        $(".cus_img").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    var id = $(this).parent().prev('.up_img').attr("id");
                    console.log(id);
                    reader.onload = function(e) {
                        $('#'+id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });


        $('#form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                type: 'POST',
                url: "{{ route('clients.update',$data->id) }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if(data.success){
                        // this.reset();
                        toastr.success(data.success);
                    }else{
                        if (typeof (data.error) !== 'undefined') {
                            toastr.error(data.error);
                        }
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
