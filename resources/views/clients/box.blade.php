@extends('layouts.main')
@section('title','Client')
@section('content')
    @include( '../sweet_script')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title'):  {{ isset($data->client->fullname) ? ($data->client->fullname) : ""}}</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">@yield('title') box</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <td width="30%">Box name</td>
                                                <td>{{$data->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td>{{ isset($data->price) ? ($data->price) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td>{{ isset($data->description) ? ($data->description) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <td>QR code</td>
                                                <td>{{ isset($data->qrcode) ? ($data->qrcode) : ""}}</td>
                                            </tr>

                                            <tr>
                                                <td>Barcode</td>
                                                <td>{{ isset($data->barcode) ? ($data->barcode) : ""}}</td>
                                            </tr>
                                             
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                
                                                    @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
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
