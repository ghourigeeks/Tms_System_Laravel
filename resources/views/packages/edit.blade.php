@extends('layouts.main')
@section('title','Payment Method')
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
                            <h4 class="card-title">Edit @yield('title')</h4><span style="margin-left:10px" class="loader"></span>
                            <a  href="{{ route('packages.index') }}" class="btn btn-primary btn-xs ml-auto">
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
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Payment name <span class="text-danger"> *</span>')) !!}
                                        {{ Form::text('name', null, array('placeholder' => 'Enter payment name','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('name'))  
                                            {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('amount','Amount <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('amount', null, array('placeholder' => 'Enter amount','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('amount'))  
                                            {!! "<span class='span_danger'>". $errors->first('amount')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('box_limit','Box limit <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('box_limit', null, array('placeholder' => 'Enter box limit','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('box_limit'))  
                                            {!! "<span class='span_danger'>". $errors->first('box_limit')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('inventory_limit','Inventory limit <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('inventory_limit', null, array('placeholder' => 'Enter inventory limit','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('inventory_limit'))  
                                            {!! "<span class='span_danger'>". $errors->first('inventory_limit')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('add_to_mp','Marketplace<span class="text-danger"> *</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->add_to_mp == "Active") || ($data->add_to_mp == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('add_to_mp',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('add_to_mp'))  
                                            {!! "<span class='span_danger'>". $errors->first('add_to_mp')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('ibeacon','Ibeacon<span class="text-danger"> *</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->ibeacon == "Active") || ($data->ibeacon == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('ibeacon',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('ibeacon'))  
                                            {!! "<span class='span_danger'>". $errors->first('ibeacon')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                  <div class="col-4">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('barcode','Barcode<span class="text-danger"> *</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->barcode == "Active") || ($data->barcode == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('barcode',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('barcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('barcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                              <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('qrcode','Qrcode<span class="text-danger"> *</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->qrcode == "Active") || ($data->qrcode == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('qrcode',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('qrcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('qrcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('active','Active<span class="text-danger"> *</span>')) !!}
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
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary  btn-sm mr-2">Save</button>
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
                    url: "{{ route('packages.update',$data->id) }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('.loader').show();
                    },
                    success: (data) => {
                        if(data.success){
                            // this.reset();
                            toastr.success(data.success);
                            $('.loader').hide();
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
                        $('.loader').hide();
                        toastr.error(txt);
                    }
                });
            });
        });
    </script>

@endsection
