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
                            <h4 class="card-title">Show @yield('title')</h4>
                            <a  href="{{ route('boxes.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>

                                            <tr>
                                                <td width="30%">Client name</td>
                                                <td>
                                                        {{ isset($data->client->fullname) ? ($data->client->fullname) : ""}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="30%">Box name</td>
                                                <td>
                                                        {{ isset($data->name) ? ($data->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Price</td>
                                                <td>
                                                        {{ isset($data->price) ? ($data->price) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">QR code</td>
                                                <td>
                                                        {{ isset($data->qrcode) ? ($data->qrcode) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Bar code</td>
                                                <td>
                                                        {{ isset($data->barcode) ? ($data->barcode) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Descripion</td>
                                                <td>
                                                        {{ isset($data->description) ? ($data->description) : ""}}
                                                </td>
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
