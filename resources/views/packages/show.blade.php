@extends('layouts.main')
@section('title','Package')
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
                            <a  href="{{ route('packages.index') }}" class="btn btn-primary btn-xs ml-auto">
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
                                                <td width="30%">Package name</td>
                                                <td>
                                                        {{ isset($data->name) ? ($data->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Amount</td>
                                                <td>
                                                        {{ isset($data->amount) ? ($data->amount) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Box limit</td>
                                                <td>
                                                        {{ isset($data->box_limit) ? ($data->box_limit) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Inventory limit</td>
                                                <td>
                                                        {{ isset($data->inventory_limit) ? ($data->inventory_limit) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Marketplace</td>
                                                <td>
                                                    @if((isset($data->add_to_mp)) && ( ($data->add_to_mp == 1) || ($data->add_to_mp == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Ibeacon</td>
                                                <td>
                                                    @if((isset($data->ibeacon)) && ( ($data->ibeacon == 1) || ($data->ibeacon == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Barcode</td>
                                                <td>
                                                    @if((isset($data->barcode)) && ( ($data->barcode == 1) || ($data->barcode == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%">Qrcode</td>
                                                <td>
                                                    @if((isset($data->qrcode)) && ( ($data->qrcode == 1) || ($data->qrcode == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
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
