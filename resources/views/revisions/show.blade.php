@extends('layouts.main')
@section('title','Revision')
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
                                                <th width="30%">Revision start time</th>
                                                <td>
                                                        {{ isset($data->start_time) ? ($data->start_time) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Revision Concepts</th>
                                                <td>
                                                        {{ isset($data->revisions) ? ($data->revisions) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Created at</th>
                                                <td>
                                                        {{ isset($data->created_at) ? ($data->created_at) : ""}}
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
                            <div class="col-6 col-md-6">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Revision name</th>
                                                <td>
                                                        {{ isset($data->order->name) ? ($data->order->name) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Revision end time</th>
                                                <td>
                                                        {{ isset($data->end_time) ? ($data->end_time) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Revision start date</th>
                                                <td>
                                                        {{ isset($data->start_date) ? ($data->start_date) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Updated at</th>
                                                <td>
                                                        {{ isset($data->updated_at) ? ($data->updated_at) : ""}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="30%">Work from</th>
                                                <td>
                                                        {{ isset($data->work_from) ? ($data->work_from) : ""}}
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
