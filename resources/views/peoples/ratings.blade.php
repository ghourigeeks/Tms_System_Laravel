@extends('layouts.main')
@section('title','Captain')
@section('content')

@include( '../sweet_script')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">@yield('title') Ratings</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"> <b>{{ ucwords($data->fname)}} Ratings</b></h4>
                    
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
                                    <th width="75%">Passenger</th>
                                    <th width="30%">rating</th>
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
                "ajax": "{{ url('peoples') }}/rtngs_lst/{{$id}}",
                "method": "GET",
                "columns": [
                    {"data": "srno"},
                    {"data": "pas_name"},
                    {"data": "rating"}
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
