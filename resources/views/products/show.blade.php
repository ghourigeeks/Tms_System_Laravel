@extends('layouts.main')
@section('title','Product')
@section('content')
    @include( '../sweet_script')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
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
                                                    @if(isset($data->subCategory->name)  )
                                                        <span class="badge badge-success">{{($data->subCategory->name)}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Added to MarketPlace</th>
                                                <td>
                                                
                                                    @if((isset($data->added_to_mp)) && ( ($data->added_to_mp == 1) || ($data->added_to_mp == "Yes") ) )
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

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Product Images</h4>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if((isset($data->productImages)) && (!empty($data->productImages)) && (count($data->productImages)) > 0 )
                                @foreach($data->productImages as $picz)
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pop">
                                        <img src="{{ $picz->pic}}" alt="..." class="avatar-img rounded mb-5 imageresource" style="width:200px; height:200px; box-shadow: 5px 7px 7px -4px rgba(97,93,93,0.67);">
                                    </div>
                                @endforeach
                            @else
                                <div class="col">
                                    <b>No product image uploaded yet!!</b>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Creates the bootstrap modal where the image will appear -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 468px; height: 264px;" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".pop").on("click", function() {
            $('#imagepreview').attr('src',$(this).find(".imageresource").attr('src'));
            $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });
    </script>
    

@endsection
