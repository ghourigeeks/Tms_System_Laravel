@extends('layouts.main')
@section('title','Order')
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
                            <h4 class="card-title">@yield('title') </h4>
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
                            <div class="col-6 col-md-6">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">User name</th>
                                                <td>
                                                        {{ isset($data->user->name) ? ($data->user->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Order name</th>
                                                <td>
                                                        {{ isset($data->name) ? ($data->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Order start time</th>
                                                <td>
                                                        {{ isset($data->start_time) ? ($data->start_time) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Order end time</th>
                                                <td>
                                                        {{ isset($data->end_time) ? ($data->end_time) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Work from</th>
                                                <td>
                                                        {{ isset($data->work_from) ? ($data->work_from) : "Not defined"}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Logo type</th>
                                                <td>
                                                        {{ isset($data->logo_type) ? ($data->logo_type) : "Not defined"}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Created at</th>
                                                <td>
                                                        {{ isset($data->created_at) ? ($data->created_at) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Final</th>
                                                <td>
                                                    @if((isset($data->final)) && ( ($data->final == 'Final') ) )
                                                        <span class="badge badge-success">Final</span>
                                                    @else
                                                        <span class="badge badge-danger">Cancel</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Order Date</th>
                                                <td>
                                                        {{ isset($data->start_date) ? ($data->start_date) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Concepts</th>
                                                <td>
                                                        {{ isset($data->concepts) ? ($data->concepts) : "0 Concepts"}}
                                                </td>
                                            </tr>
                                            @if(Auth::user()->id == 1)
                                            <tr>
                                                <th width="30%">Payment</th>
                                                <td>
                                                        {{ isset($data->payment) ? ($data->payment) : "0 Rs"}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Total Payment</th>
                                                <td>
                                                        {{ isset($data->total_payment) ? ($data->total_payment) : "0 Rs"}}
                                                </td>
                                            </tr>
                                            
                                            @else
                                            <tr>
                                                <th width="30%">Payment</th>
                                                <td>0 Rs</td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Total Payment</th>
                                                <td>0 Rs</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>Client</th>
                                                <td>
                                                   {{ isset($data->client->name) ? ($data->client->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Logo category</th>
                                                <td>
                                                        {{ isset($data->category->name) ? ($data->category->name) : "Not defined"}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Updated at</th>
                                                <td>
                                                        {{ isset($data->updated_at) ? ($data->updated_at) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Complete</th>
                                                <td>
                                                    @if((isset($data->complete)) && ( ($data->complete == 'Completed') ) )
                                                        <span class="badge badge-success">Complete</span>
                                                    @else
                                                        <span class="badge badge-danger">Incomplete</span>
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
