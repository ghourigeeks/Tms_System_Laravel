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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Product(s) in box</h4>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th width="30%">Product </th>
                                                <th>Price</th>
                                                <th>Qty in box</th>
                                                <th data-toggle="tooltip" data-placement="top" title="This product is added to Marketplace">Added to marketplace</th>
                                                <th>Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( (!empty($boxProducts)) && (isset($boxProducts)))
                                                @foreach($boxProducts as $key => $boxProduct)
                                                    <tr>
                                                        <td>{{ isset($boxProduct->product->name) ? ($boxProduct->product->name) : ""}}</td>
                                                        <td>{{ isset($boxProduct->product->price) ? ($boxProduct->product->price) : ""}}</td>
                                                        <td>{{ isset($boxProduct->qty) ? ($boxProduct->qty) : ""}}</td>
                                                        <td>
                                                            @if((isset($boxProduct->product->added_to_mp)) && ( ($boxProduct->product->added_to_mp == 1) || ($boxProduct->product->added_to_mp == "Yes") ) )
                                                                <span class="badge badge-success">Yes</span>
                                                            @else
                                                               <span class="badge badge-danger">No</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if((isset($boxProduct->product->active)) && ( ($boxProduct->product->active == 1) || ($boxProduct->product->active == "Active") ) )
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif                                           
                                          
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
    

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endsection
