@extends('layouts.main')
@section('title','People')
@section('content')

@include( '../sweet_script')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">@yield('title') Bookings: {{ucwords($data->fname)}}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"> @yield('title') Bookings </h4>
                    
                            <a  href="{{ url('peoples')}}/{{$id}}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover" style="width: 100%;" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Pickup city </th>
                                    <th>Dropoff City </th>
                                    <th>Schedule Time</th>
                                    <th>Book Seat</th>
                                    <th>Status</th>
                                    <!-- <th width="10%" >Action</th> -->
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
                "ajax": "{{ url('peoples') }}/bkngs_lst/{{$id}}",
                "method": "GET",
                "columns": [
                    {"data": "srno"},
                    {"data": "pickup_city"},
                    {"data": "dropoff_city"},
                    {"data": "schedule_time"},
                    {"data": "book_seat"},
                    {"data": "status_name"}
                    // ,
                    // {"data": "action",orderable:false,searchable:false}

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
