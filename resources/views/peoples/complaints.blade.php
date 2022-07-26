@extends('layouts.main')
@section('title','Captain')
@section('content')

@include( '../sweet_script')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Complaints on  @yield('title')</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"> <b>Complaints on {{ ucwords($data->fname)}}</b></h4>
                    
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
                                    <th width="25%">Passenger</th>
                                    <th width="20%">Complaint tag</th>
                                    <th width="50%">Description </th>
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
                "ajax": "{{ url('peoples') }}/cmplnts_lst/{{$id}}",
                "method": "GET",
                "columns": [
                    {"data": "srno"},
                    {"data": "pas_name"},
                    {"data": "com_name"},
                    {"data": "detail"}
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
