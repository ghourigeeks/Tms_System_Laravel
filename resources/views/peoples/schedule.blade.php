@extends('layouts.main')
@section('title','People')
@section('content')
    @include( '../sweet_script')
    <style>
        .cardno-before .card:before {
            opacity: 0;
        }
        .cardno-before .col-stats {
            padding: 0;
        }
        hr.dotted-border {
        border: none;
        border-bottom: 2px dashed #a5a5a5;
    }
    </style>
    <div class="page-inner">
        <h4 class="page-title">
            @yield('title') schedule:  {{ucwords($data->cap_name)}}
            @if(($data->status_id) ==  5)  <!-- 5: cancelled -->
                <span class="badge badge-danger"><b>Current status: {{($data->status_name)}}</b> </span>
            @else
                <span class="badge badge-primary"><b>Current status: {{($data->status_name)}}</b> </span>
            @endif
            <span class="badge badge-warning pull-right"><b><b>Created on: {{($data->created_at)}}</b> </span>
        </h4>
        
       
        
        <div class="row">

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> @yield('title') details </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="50%">@yield('title') Name</th>
                                            <td>
                                                <b><a href="{{ url('peoples')}}/{{$data->cap_id}}"> {{ucwords($data->cap_name)}}</a></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th >Vacant seats</th>
                                            <td><b>{{$data->vacant_seat}}</b></td>
                                        </tr>
                                        <tr>
                                            <th>Fare</th>
                                            <td><span class="badge badge-success">Rs. {{$data->fare}} / seat</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> @yield('title') pickup details </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="20%">City: </th>
                                            <td>
                                                @if(isset($data->pickup_city))
                                                    {{$data->pickup_city}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td>
                                                @if(isset($data->pickup_address))
                                                    {{$data->pickup_address}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Time: </th>
                                            <td>
                                                @if(isset($data->schedule_time))
                                                    <span class="badge badge-success">{{$data->schedule_time}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> @yield('title') dropoff details </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="20%">City: </th>
                                            <td>
                                                @if(isset($data->dropoff_city))
                                                    {{$data->dropoff_city}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td>
                                                @if(isset($data->dropoff_address))
                                                    {{$data->dropoff_address}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Time: </th>
                                            <td>
                                                <!-- @if(isset($data->dropoff_time))
                                                    <span class="badge badge-success">{{$data->dropoff_time}}</span>
                                                @endif -->
                                                <span class="badge badge-success">TBD</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Passengers </h4>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th>#</th>
                                            <th>Passengers</th>
                                            <th>Seats</th>
                                            <th>Scheduled on</th>
                                        </tr>
                                        @if(!(count($passengers) > 0 ))
                                            <tr>
                                                <td colspan=7>
                                                    <span class="badge badge-danger">No passenger found</span>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($passengers as $passenger)
                                                <tr>
                                                    <td>
                                                        @if($passenger->pas_name)
                                                            <b><a href="{{ url('peoples')}}/shdls/shdl/{{$passenger->schedule_id}}"> {{ucwords($passenger->schedule_id)}}</a></b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($passenger->profile_pic)
                                                            <img src="{{ asset('/uploads/peoples/'.$passenger->profile_pic) }}" alt="..." class="avatar-img rounded-circle" style="width:40px; height:40px">
                                                        @else
                                                            <img src="{{ asset('/uploads/no_image.png') }}" alt="..." class="avatar-img rounded-circle" style="width:40px; height:40px">
                                                        @endif

                                                        @if($passenger->pas_name)
                                                        <b><a href="{{ url('peoples')}}/{{$passenger->pas_id}}"> {{ucwords($passenger->pas_name)}}</a></b>
                                                        @endif

                                                        
                                                    </td>
                                                    <td><span class="badge badge-success">{{ $passenger->book_seat }}</span></td>
                                                   
                                                    <td>
                                                        @if($passenger->created_at)
                                                            <b>{{$passenger->created_at}}</b>
                                                        @endif
                                                    </td>
                                                    
                                                    
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Schedule history </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th>Status</th>
                                            <th>Timestamp</th>
                                        </tr>
                                        @if(!(count($histories) > 0 ))
                                            <tr>
                                                <td colspan=2>
                                                    <span class="badge badge-danger">No history found</span>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($histories as $history)
                                                <tr>
                                                    <td>
                                                        @if(($history->status_name) && ($history->status_id == 1))
                                                            <span class="badge badge-primary">{{$history->status_name}}</span>
                                                        @elseif(($history->status_name) && ($history->status_id == 2))
                                                            <span class="badge badge-warning">{{$history->status_name}}</span>
                                                        @elseif(($history->status_name) && ($history->status_id == 3))
                                                            <span class="badge badge-info">{{$history->status_name}}</span>
                                                        @elseif(($history->status_name) && ($history->status_id == 4))
                                                            <span class="badge badge-success">{{$history->status_name}}</span>
                                                        @elseif(($history->status_name) && ($history->status_id == 5))
                                                            <span class="badge badge-danger">{{$history->status_name}}</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{$history->status_name}}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($history->created_at)
                                                            {{$history->created_at}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
