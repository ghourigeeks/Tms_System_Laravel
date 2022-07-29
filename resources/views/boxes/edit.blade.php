@extends('layouts.main')
@section('title','Boxes')
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
                            <a  href="{{ route('boxes.index') }}" class="btn btn-primary btn-xs ml-auto">
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
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('client_id','Client ID')) !!}<span class="text-danger"> *</span>
                                        {!! Form::select('client_id',['' => 'Please select']+ $clients,[$data->client_id], array('class' => 'form-control', 'id','autofocus' => 'region')) !!}
                                        @if ($errors->has('client_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('client_id')."</span>"!!} 
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
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Box name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('name', $data->name, array('placeholder' => 'Enter box name','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('name'))  
                                            {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('price','Box price <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('price', $data->price, array('placeholder' => 'Enter box price','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('price'))  
                                            {!! "<span class='span_danger'>". $errors->first('price')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('qrcode','QR code <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('qrcode', $data->qrcode, array('placeholder' => 'Enter QR code','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('qrcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('qrcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                       {!! Html::decode(Form::label('barcode','Bar code <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('barcode', $data->barcode, array('placeholder' => 'Enter bar code','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('barcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('barcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('description','Box description <span class="text-danger">*</span>')) !!}
                                        {{ Form::textarea('description',$data->description, array('placeholder' => 'Enter box description key','class' => 'form-control','rows'=>'6'  )) }}
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
                                    <button type="submit" class="btn btn-primary btn-sm mr-2">Save</button>
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
                    url: "{{ route('boxes.update',$data->id) }}",
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
        });
    </script>

@endsection