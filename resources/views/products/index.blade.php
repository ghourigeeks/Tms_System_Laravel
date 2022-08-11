@extends('layouts.main')
@section('title','Products')
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
                            <h4 class="card-title">Manage @yield('title')</h4>
                            @can('product-create')
                                <a  href="{{ route('products.create') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fa fa-plus"></i> New</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-hover" style="width: 100%;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Client name</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Total Qty</th>
                                        <th data-toggle="tooltip" data-placement="top" title="Qty in Marketplace">Qty in Marketplace</th>
                                        <th width="18%" data-toggle="tooltip" data-placement="top" title="This product is added to Marketplace">Marketplace</th>
                                        <th width="8%"> Active</th>
                                        <th width="10%" >Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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

    <script>
        $(document).ready(function () {  
            var t = $('#myTable').DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": false,
                    "select":true,
                    "ajax": "{{ url('lst_product') }}",
                    "method": "GET",
                    "columns": [
                        {"data": "srno"},
                        {"data": "client_name"},
                        {"data": "name"},
                        {"data": "price"},
                        {"data": "qty"},
                        {"data": "qty_to_mp"},
                        {"data": "added_to_mp"},
                        {"data": "active",orderable:false,searchable:false},
                        {"data": "action",orderable:false,searchable:false}

                    ]
                });
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();


        });
    </script>
@endsection
