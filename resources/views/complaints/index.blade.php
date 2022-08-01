@extends('layouts.main')
@section('title','Complaint')
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
                          
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-hover" style="width: 100%;" cellspacing="0">
                               
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
                    "select":false,
                    "ajax": "{{ url('lst_complaint') }}",
                    "method": "GET",
                    "columns": [
                        // {"data": "srno"},
                        {"data": "profile_pic",orderable:false,searchable:false},
                        {"data": "client_name",orderable:false,searchable:false},
                        // {"data": "subject",orderable:false,searchable:false},
                        {"data": "created_at",orderable:false,searchable:false}

                    ]
                });
           


        });
    </script>
@endsection
