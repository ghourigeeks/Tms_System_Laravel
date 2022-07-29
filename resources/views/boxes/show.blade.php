@extends('layouts.main')
@section('title','Box')
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
                            <h4 class="card-title">@yield('title') box</h4>
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Box name</th>
                                                <td>{{$data->name}}</td>
                                                <th width="30%">QR code</th>
                                                <td>{{ isset($data->qrcode) ? ($data->qrcode) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <th>Price</th>
                                                <td>{{ isset($data->price) ? ($data->price) : ""}}</td>
                                                <th>Barcode</th>
                                                <td>{{ isset($data->barcode) ? ($data->barcode) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <th>Description</th>
                                                <td colspan="3">{{ isset($data->description) ? ($data->description) : ""}}</td>
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
