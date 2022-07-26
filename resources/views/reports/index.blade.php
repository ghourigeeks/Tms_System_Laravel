@extends('layouts.main')
@section('title','Report')
@section('content')

@include( '../sweet_script')


<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">@yield('title')</h4>
    </div>


     <!-- Single Daily reporting reporting  -->
     <div class="row">
    
        <!-- Single Dail reporting  -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Find Daily @yield('title')</h4>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(array('route' => 'reports.store','method'=>'POST','id'=>'form','enctype'=>'multipart/form-data')) !!}
                    {{  Form::hidden('entity', 'daily_report' ) }}

                    <div class="card-body">
                        <div class=" row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('report_date','Select Date for daily report <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('report_date', null, array('class' => 'form-control' ,'autofocus' => '' )) }}
                                    @if ($errors->has('report_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('report_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Find</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
    </div>

    <!-- Single Entities reporting  -->
    <div class="row">
        <!-- Single Company reporting  -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Find One Company @yield('title')</h4>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(array('route' => 'reports.store','method'=>'POST','id'=>'form','enctype'=>'multipart/form-data')) !!}
                    {{  Form::hidden('entity', 'company_single' ) }}

                    <div class="card-body">
                        <div class=" row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('company_id','Company Name ')) !!}
                                    {!! Form::select('company_id', $companies,null, array('class' => 'form-control')) !!}
                                    @if ($errors->has('company_id'))  
                                        {!! "<span class='span_danger'>". $errors->first('company_id')."</span>"!!} 
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('company_start_date','Start date <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('company_start_date', null, array('placeholder' => 'Select Date for Company Transaction','class' => 'form-control')) }}
                                    @if ($errors->has('company_start_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('company_start_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('company_end_date','End date <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('company_end_date', null, array('placeholder' => 'Select Date for Company Transaction','class' => 'form-control')) }}
                                    @if ($errors->has('company_end_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('company_end_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Find</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>

        <!-- Single Customer reporting  -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Find One Customer @yield('title')</h4>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(array('route' => 'reports.store','method'=>'POST','id'=>'form','enctype'=>'multipart/form-data')) !!}
                    {{  Form::hidden('entity', 'customer_single' ) }}

                    <div class="card-body">
                        <div class=" row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('customer_id','Customer Name ')) !!}
                                    {!! Form::select('customer_id', $customers,null, array('class' => 'form-control')) !!}
                                    @if ($errors->has('customer_id'))  
                                        {!! "<span class='span_danger'>". $errors->first('customer_id')."</span>"!!} 
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        <div class=" row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('customer_start_date','Start date <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('customer_start_date', null, array('placeholder' => 'Select Date for Company Transaction','class' => 'form-control')) }}
                                    @if ($errors->has('customer_start_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('customer_start_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('customer_end_date','End date <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('customer_end_date', null, array('placeholder' => 'Select Date for Company Transaction','class' => 'form-control')) }}
                                    @if ($errors->has('customer_end_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('customer_end_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Find</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
    </div>


    <!-- Entire entity reporting -->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Find All Company @yield('title')</h4>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(array('route' => 'reports.store','method'=>'POST','id'=>'form','enctype'=>'multipart/form-data')) !!}
                    {{  Form::hidden('entity', 'company' ) }}

                    <div class="card-body">
                        <div class=" row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('company_date','Select Date for Company Transaction <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('company_date', null, array('placeholder' => 'Select Date for Company Transaction','class' => 'form-control' )) }}
                                    @if ($errors->has('company_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('company_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Find</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Find All Customer @yield('title')</h4>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(array('route' => 'reports.store','method'=>'POST','id'=>'form','enctype'=>'multipart/form-data')) !!}
                    {{  Form::hidden('entity', 'customer' ) }}

                    <div class="card-body">
                        <div class=" row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('customer_date','Select Date for Customer Transaction <span class="text-danger">*</span>')) !!}
                                    {{ Form::date('customer_date', null, array('placeholder' => 'Select Date for Customer Transaction','class' => 'form-control')) }}
                                    @if ($errors->has('customer_date'))  
                                        {!! "<span class='span_danger'>". $errors->first('customer_date')."</span>"!!} 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-primary mr-2">Find</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Form-->
            </div>
        </div>
    </div>

    

    
</div>
  

@endsection
