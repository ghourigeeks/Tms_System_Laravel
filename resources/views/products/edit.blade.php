@extends('layouts.main')
@section('title','Product')
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
                            <a  href="{{ route('products.index') }}" class="btn btn-primary btn-xs ml-auto">
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
                                <div class="col-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Product name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('name', null, array('placeholder' => 'Enter product name','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('name'))  
                                            {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                              <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('client_id','Client name<span class="text-danger"> *</span>')) !!}
                                        {!! Form::select('client_id', ['' => 'Please select']+ $client,[$client_id->id], array('class' => 'form-control', 'id' => 'client_id')) !!}
                                        @if ($errors->has('client_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('client_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('color','Product color <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('color', null, array('placeholder' => 'Enter product color','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('color'))  
                                            {!! "<span class='span_danger'>". $errors->first('color')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('price','Product price <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('price', null, array('placeholder' => 'Enter product price','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('price'))  
                                            {!! "<span class='span_danger'>". $errors->first('price')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('category_id','Category name<span class="text-danger"> *</span>')) !!}
                                        {!! Form::select('category_id', ['' => 'Please select']+ $category,[$category_id->id], array('class' => 'form-control', 'id' => 'category_id')) !!}
                                        @if ($errors->has('category_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('category_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('sub_category_id','Subcategory name<span class="text-danger"> *</span>')) !!}
                                        {!! Form::select('sub_category_id', ['' => 'Please select']+ $sub_category,[$sub_category_id->id], array('class' => 'form-control', 'id' => 'sub_category_id')) !!}
                                        @if ($errors->has('sub_category_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('sub_category_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('qrcode','Product qrcode <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('qrcode', null, array('placeholder' => 'Enter product qrcode','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('qrcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('qrcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('barcode','Product barcode <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('barcode', null, array('placeholder' => 'Enter product barcode','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('barcode'))  
                                            {!! "<span class='span_danger'>". $errors->first('barcode')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('qty','Product quantity <span class="text-danger">*</span>')) !!}
                                        {{ Form::number('qty', null, array('placeholder' => 'Enter product quantity','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('qty'))  
                                            {!! "<span class='span_danger'>". $errors->first('qty')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('lat','Product latitude <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('lat', null, array('placeholder' => 'Enter product latitude','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('lat'))  
                                            {!! "<span class='span_danger'>". $errors->first('lat')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('lng','Product longitude  <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('lng', null, array('placeholder' => 'Enter product longitude ','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('lng'))  
                                            {!! "<span class='span_danger'>". $errors->first('lng')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('description','Product description <span class="text-danger">*</span>')) !!}
                                        {{ Form::textarea('description', null, array('placeholder' => 'Enter product description','class' => 'form-control','rows' => '6'  )) }}
                                        @if ($errors->has('description'))  
                                            {!! "<span class='span_danger'>". $errors->first('description')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                       {!! Html::decode(Form::label('add_to_mp','Marketplace<span class="text-danger"> *</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->added_to_mp == "Yes") || ($data->added_to_mp == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('added_to_mp',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('added_to_mp'))  
                                            {!! "<span class='span_danger'>". $errors->first('added_to_mp')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
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
                    url: "{{ route('products.update',$data->id) }}",
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
