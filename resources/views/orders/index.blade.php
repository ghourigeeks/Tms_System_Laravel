@extends('layouts.main')
@section('title','Orders')
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
                            @can('order-create')
                                <a style="margin-right: 5px;"  href="{{ route('orders.create') }}" class="btn btn-dark btn-xs ml-auto">
                                <i class="fa fa-plus"></i> New</a>
                            @endcan
                            @if(Auth::user()->id == 1)
                            <a href="{{ route('orders.export') }}" class="btn btn-primary btn-xs">
                             <i class="fa fa-print"></i> Export Data </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-hover" style="width: 100%;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>User name</th>
                                        <th>Order Name</th>
                                        <th>Work status</th>
                                        <th>Start date</th>
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
        $(document).ready(function () {  
            var t = $('#myTable').DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": false,
                    "select":true,
                    "ajax": "{{ url('lst_order') }}",
                    "method": "GET",
                    "columns": [
                        {"data": "srno"},
                        {"data": "user_name"},
                        {"data": "name"},
                        {"data": "complete"},
                        {"data": "start_date"},
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
