@extends('layouts.main')
@section('title','Revision')
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
                            <a  href="{{ route('revisions.index') }}" class="btn btn-dark btn-xs ml-auto">
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
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('start_date','Revision Date <span class="text-danger">*</span>')) !!}
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
                                        {!! Html::decode(Form::label('order_id','Revision name')) !!}<span class="text-danger"> *</span>
                                            {!! Form::select('order_id',['' => 'Please select']+ $order,[$order_id->id], array('class' => 'form-control', 'id','autofocus' => 'user')) !!}
                                            @if ($errors->has('order_id'))  
                                                {!! "<span class='span_danger'>". $errors->first('order_id')."</span>"!!} 
                                            @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('revisions','Revision Concepts')) !!}
                                         <select name="revisions" id="revisions" class="form-control">
                                            <option value="">Please select</option>
                                                <option value="1 Revision" {{ $data->revisions == 1 ? 'selected' : '' }}>1 Revision</option>
                                                <option value="2 Revision" {{ $data->revisions == 2 ? 'selected' : '' }}>2 Revision</option>
                                                <option value="3 Revision" {{ $data->revisions == 3 ? 'selected' : '' }}>3 Revision</option>
                                                <option value="4 Revision" {{ $data->revisions == 4 ? 'selected' : '' }}>4 Revision</option>
                                                <option value="5 Revision" {{ $data->revisions == 5 ? 'selected' : '' }}>5 Revision</option>
                                                <option value="6 Revision" {{ $data->revisions == 6 ? 'selected' : '' }}>6 Revision</option>
                                                <option value="7 Revision" {{ $data->revisions == 7 ? 'selected' : '' }}>7 Revision</option>
                                                <option value="8 Revision" {{ $data->revisions == 8 ? 'selected' : '' }}>8 Revision</option>
                                                <option value="9 Revision" {{ $data->revisions == 9 ? 'selected' : '' }}>9 Revision</option>
                                                <option value="10 Revision" {{ $data->revisions == 10 ? 'selected' : '' }}>10 Revision</option>
                                         </select> 
                                        @if ($errors->has('revisions'))  
                                            {!! "<span class='span_danger'>". $errors->first('revisions')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('start_time','Revision start time <span class="text-danger">*</span>')) !!}
                                        {{ Form::time('start_time', null, array('class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('start_time'))  
                                            {!! "<span class='span_danger'>". $errors->first('start_time')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('end_time','Revision end time <span class="text-danger">*</span>')) !!}
                                        {{ Form::time('end_time', null, array('class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('end_time'))  
                                            {!! "<span class='span_danger'>". $errors->first('end_time')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                    url: "{{ route('revisions.update',$data->id) }}",
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
