@extends('layouts.main')
@section('title','Leave')
@section('content')
    @include( '../sweet_script')

    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="card response-form">
                    <div class="card-header">
                       <!--begin::Form-->
                     <form action="{{ route('leaves.update',$data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                             <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('pending','pending')) !!}
                                         <select name="pending" id="pending" class="form-control">
                                                <option valpuue="Approve" {{ $data->pending == 'Approve' ? 'selected' : '' }}>Approve</option>
                                                <option value="Cancel"   {{ $data->pending == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                         </select> 
                                        @if ($errors->has('pending'))  
                                            {!! "<span class='span_danger'>". $errors->first('pending')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-dark btn-sm">Submit Response</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <!--end::Form-->
                    </div>
                    <div class="card-fooer"></div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Show @yield('title')</h4>
                            <span class="ml-2">
                                @if($data->pending == null || $data->pending == "")
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($data->pending == 'Cancel')
                                    <span class="badge badge-danger">Not Approve</span>
                                @else
                                    <span class="badge badge-success">Approve</span>
                                @endif
                            </span>
                            <div class="pull-right ml-2">
                             @if(Auth::user()->id == 1)
                                @if($data->pending == null || $data->pending == "")
                                 <a class="text-light btn btn-primary btn-sm response-btn">Response</a>
                                @endif
                             @endif
                            </div>
                            
                            <a  href="{{ route('leaves.index') }}" class="btn btn-dark btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Name</th>
                                                <td>{{ isset($data->user->name) ? ($data->user->name) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ isset($data->userEmail->email) ? ($data->userEmail->email) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th width="15%">Subject</th>
                                                <td>{{ isset($data->subject) ? ($data->subject) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th width="15%">Leave start</th>
                                                <td>{{ isset($data->leave_start) ? ($data->leave_start) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                     @if((isset($data->active)) && ( ($data->active == 1) || ($data->active == "Active") ) )
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="30%">Contact</th>
                                                <td>{{ isset($data->userContact->contact_no) ? ($data->userContact->contact_no) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th>lodged on</th>
                                                <td>{{ isset($data->created_at) ? ($data->created_at) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th width="15%">Reason</th>
                                                <td>{{ isset($data->reason) ? ($data->reason) : "Not defined"}}</td>
                                            </tr>
                                            <tr>
                                                <th width="15%">Leave end</th>
                                                <td>{{ isset($data->leave_end) ? ($data->leave_end) : "Not defined"}}</td>
                                            </tr>
                                            @if($data->pending != null || $data->pending != "Not defined")
                                            <tr>
                                                <th width="15%">Response</th>
                                                <td>{{ isset($data->pending) ? ($data->pending) : "Not defined"}}</td>
                                            </tr>
                                            @endif
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
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".response-btn").click(function(){
            $(".response-form").slideToggle("medium");
        });
    });
</script>
    

@endsection