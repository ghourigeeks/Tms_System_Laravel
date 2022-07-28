@extends('layouts.main')
@section('title','Client')
@section('content')
    @include( '../sweet_script')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title'):  {{ isset($data->client->fullname) ? ($data->client->fullname) : ""}}</h4>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Prdduct General</h4>
                            <span class="ml-auto">
                                @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 col-md-8">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Product name</th>
                                                <td>{{$data->name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <td>{{ isset($data->description) ? ($data->description) : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th>QR code</th>
                                                <td>{{ isset($data->qrcode) ? ($data->qrcode) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <th>Barcode</th>
                                                <td>{{ isset($data->barcode) ? ($data->barcode) : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Prdduct Details</h4>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th>Category</th>
                                                <td>
                                                    @if(isset($data->category->name)  )
                                                        <span class="badge badge-primary">{{($data->category->name)}}</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Sub Category</th>
                                                <td>
                                                    @if(isset($data->sub_category->name)  )
                                                        <span class="badge badge-success">{{($data->sub_category->name)}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Added to MarketPlace</th>
                                                <td>
                                                
                                                    @if((isset($data->added_to_mp)) && ( ($data->added_to_mp == 1) || ($data->added_to_mp == "Active") ) )
                                                        <span class="badge badge-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-danger">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th>Price</th>
                                                <td>{{ isset($data->price) ? ($data->price) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th>Color</th>
                                                <td>{{ isset($data->color) ? ($data->color) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th>Quantity</th>
                                                <td>{{ isset($data->qty) ? ($data->qty) : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
