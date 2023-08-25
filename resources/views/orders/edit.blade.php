    @extends('layouts.main')
@section('title','Order')
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
                            <a  href="{{ route('orders.index') }}" class="btn btn-dark btn-xs ml-auto">
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
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        @if(Auth::user()->id == 1)
                                        
                                        {!! Html::decode(Form::label('user_id','User name')) !!}<span class="text-danger"> *</span>
                                            {!! Form::select('user_id',['' => 'Please select']+ $user,[$user_id->id], array('class' => 'form-control', 'id','autofocus' => 'user')) !!}
                                            @if ($errors->has('user_id'))  
                                                {!! "<span class='span_danger'>". $errors->first('user_id')."</span>"!!} 
                                            @endif
                                        
                                        @else

                                        {!! Form::select('user_id',['' => 'Please select']+ $user,[$user_id->id], array('class' => 'form-control', 'id','autofocus' => 'user','hidden')) !!}
                                            @if ($errors->has('user_id'))  
                                                {!! "<span class='span_danger'>". $errors->first('user_id')."</span>"!!} 
                                            @endif
                                        
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                            {!! Html::decode(Form::label('client_id','Client name')) !!}<span class="text-danger"> *</span>
                                            {!! Form::select('client_id',['' => 'Please select']+ $client,[$client_id->id], array('class' => 'form-control', 'id','autofocus' => 'user')) !!}
                                            @if ($errors->has('client_id'))  
                                                {!! "<span class='span_danger'>". $errors->first('client_id')."</span>"!!} 
                                            @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('start_date','Order Date <span class="text-danger">*</span>')) !!}
                                        {{ Form::date('start_date', null, array('class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('start_date'))  
                                            {!! "<span class='span_danger'>". $errors->first('start_date')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Order name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('name', null, array('placeholder' => 'Enter order name','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('name'))  
                                            {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('concepts','Concepts')) !!}
                                         <select name="concepts" id="concepts" class="form-control">
                                            <option value="">Please select</option>
                                                <option value="1 concept" {{ $data->concepts == 1 ? 'selected' : '' }}>1 concept</option>
                                                <option value="2 concept" {{ $data->concepts == 2 ? 'selected' : '' }}>2 concept</option>
                                                <option value="3 concept" {{ $data->concepts == 3 ? 'selected' : '' }}>3 concept</option>
                                                <option value="4 concept" {{ $data->concepts == 4 ? 'selected' : '' }}>4 concept</option>
                                                <option value="5 concept" {{ $data->concepts == 5 ? 'selected' : '' }}>5 concept</option>
                                                <option value="6 concept" {{ $data->concepts == 6 ? 'selected' : '' }}>6 concept</option>
                                                <option value="7 concept" {{ $data->concepts == 7 ? 'selected' : '' }}>7 concept</option>
                                                <option value="8 concept" {{ $data->concepts == 8 ? 'selected' : '' }}>8 concept</option>
                                                <option value="9 concept" {{ $data->concepts == 9 ? 'selected' : '' }}>9 concept</option>
                                                <option value="10 concept" {{ $data->concepts == 10 ? 'selected' : '' }}>10 concept</option>
                                         </select> 
                                        @if ($errors->has('concepts'))  
                                            {!! "<span class='span_danger'>". $errors->first('concepts')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('start_time','Order start time <span class="text-danger">*</span>')) !!}
                                        {{ Form::time('start_time', null, array('class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('start_time'))  
                                            {!! "<span class='span_danger'>". $errors->first('start_time')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('end_time','Order end time <span class="text-danger">*</span>')) !!}
                                        {{ Form::time('end_time', null, array('class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('end_time'))  
                                            {!! "<span class='span_danger'>". $errors->first('end_time')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('logo_type','Logo type')) !!}
                                         <select name="logo_type" id="logo_type" class="form-control">
                                                <option value="">Please select</option>
                                                <option value="IconBased" {{ $data->logo_type == 'IconBased' ? 'selected' : '' }}>IconBased</option>
                                                <option value="TextBased"   {{ $data->logo_type == 'TextBased' ? 'selected' : '' }}>TextBased</option>
                                                <option value="Mascot" {{ $data->logo_type == 'Mascot' ? 'selected' : '' }}>Mascot</option>
                                                <option value="Illustration"   {{ $data->logo_type == 'Illustration' ? 'selected' : '' }}>Illustration</option>
                                                <option value="SemiMascot" {{ $data->logo_type == 'SemiMascot' ? 'selected' : '' }}>SemiMascot</option>
                                                <option value="Cancel"   {{ $data->logo_type == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                         </select> 
                                        @if ($errors->has('logo_type'))  
                                            {!! "<span class='span_danger'>". $errors->first('logo_type')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('category_id','category name')) !!}
                                        {!! Form::select('category_id', ['' => 'Please select']+ $category,[$category_id->id], array('class' => 'form-control', 'id' => 'category_id')) !!}
                                        @if ($errors->has('category_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('category_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->id == 1)
                              <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('payment','Order payment')) !!}
                                        {{ Form::number('payment', null, array('placeholder' => 'Enter order payment','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('payment'))  
                                            {!! "<span class='span_danger'>". $errors->first('payment')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('total_payment','Total Payment')) !!}
                                        {{ Form::number('total_payment', null, array('placeholder' => 'Enter order total payment','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('total_payment'))  
                                            {!! "<span class='span_danger'>". $errors->first('total_payment')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                             </div>
                            @else
                            <!-- Do nothing -->
                            @endif
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('complete','Complete')) !!}
                                         <select name="complete" id="complete" class="form-control">
                                                <option value="Completed" {{ $data->complete == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="Incompleted"   {{ $data->complete == 'Incompleted' ? 'selected' : '' }}>Incompleted</option>
                                         </select> 
                                        @if ($errors->has('complete'))  
                                            {!! "<span class='span_danger'>". $errors->first('complete')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('final','Final')) !!}
                                         <select name="final" id="final" class="form-control">
                                                <option value="Final" {{ $data->final == 'Final' ? 'selected' : '' }}>Final</option>
                                                <option value="Cancel"   {{ $data->final == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                         </select> 
                                        @if ($errors->has('final'))  
                                            {!! "<span class='span_danger'>". $errors->first('final')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('work_from','Work from')) !!}
                                         <select name="work_from" id="work_from" class="form-control">
                                                <option value="">Select your working place</option>
                                                <option value="Home" {{ $data->work_from == 'Home' ? 'selected' : '' }}>Home</option>
                                                <option value="Office"   {{ $data->work_from == 'Office' ? 'selected' : '' }}>Office</option>
                                         </select> 
                                        @if ($errors->has('work_from'))  
                                            {!! "<span class='span_danger'>". $errors->first('work_from')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('active','Active')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($data->active == "Active") || ($data->active == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                            <label>
                                                {!! Form::checkbox('active',1,$actv,  array('class' => 'form-control')) !!}

                                                <span class="slider round "></span>
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
                                    <button type="submit" class="btn btn-dark  btn-sm mr-2">Save</button>
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
                    url: "{{ route('orders.update',$data->id) }}",
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
