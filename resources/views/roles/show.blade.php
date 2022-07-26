@extends('layouts.admin')

@section('title','Roles')
@section('content')
@include( '../sweet_script')
<div class="form-element-area" >
        <div class="container" style="box-shadow:0px 0px 11px 4px #d4d4d4">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                    <div class="row">
			           <div class="col-lg-10">
                            <div class="basic-tb-hd">
                              <h2>Role Data</h2>
                              <p>It's just that simple. Turn your simple table into a sophisticated data table</p>
                            </div>
                          </div>
                          <div class="col-lg-2">
                            <div class="basic-tb-hd">
                              <div class="pull-right">
                                  <a class="btn btn-success notika-btn-success waves-effect" href="{{ route('roles.index') }}"> 
                                  <i class="notika-icon notika-left-arrow"></i>  Back
                                </a>
                              </div>
                            </div>
                          </div>
                        </div> 
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="invoice-wrap">
                                    <div class="invoice-img" style="box-shadow:0px 0px 11px 4px #d4d4d4">
                                    <h2 style="color:white">{{ $role->name }}</h2>
                                    </div>
                                    <div class="invoice-hds-pro">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="invoice-cmp-ds ivc-frm">
                                                   
                                                    <div class="comp-tl">
                                                        <h2>Role Name</h2>
                                                        
                                                    </div>
                                                    <div class="cmp-ph-em">
                                                    Role has Permission
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="invoice-cmp-ds ivc-to">
                                                    
                                                    <div class="comp-tl">
                                                        <h2>{{ $role->name }}</h2>
                                                       
                                                    </div>
                                                    <div class="cmp-ph-em">
                                                    @if(!empty($rolePermissions))
                                                        @foreach($rolePermissions as $v)
                                                            <label class="label label-success">{{ $v->name }}</label>
                                                        @endforeach
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                            <div class="invoice-hs" style="box-shadow:0px 0px 11px 4px #d4d4d4">
                                                <span>Created At</span>
                                                <h2>{{ $role->created_at }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12" >
                                            <div class="invoice-hs date-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0"  style="box-shadow:0px 0px 11px 4px #d4d4d4">
                                                <span>Updated At</span>
                                                <h2>{{ $role->updated_at }}</h2>
                                            </div>
                                        </div>
<!-- 
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="invoice-hs wt-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0">
                                                <span>Whatever</span>
                                                <h2>472-000</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="invoice-hs gdt-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0">
                                                <span>Grand Total</span>
                                                <h2>$25,980</h2>
                                            </div>
                                        </div>
                                         -->
                                    </div>  
                                </div>
                            </div>
                        </div>

    
                    </div>
                </div>
            </div>
        </div>
    </div>
  
@endsection