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

                <div class="card response-form">
                    <div class="card-header">
                       <!--begin::Form-->
                     <form action="{{ route('complaints.update',$data->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                             <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        {{ Form::textarea('res', null, array('placeholder' => 'Enter response','class' => 'form-control','autofocus' => '', 'rows'=>3  )) }}
                                        @if ($errors->has('res'))  
                                        {!! "<span class='span_danger'>". $errors->first('res')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit Response</button>
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
                                @if($data->res == null || $data->res == "")
                                    <span class="badge badge-danger">Not-responded</span>
                                @else
                                    <span class="badge badge-success">Responded</span>
                                @endif
                            </span>
                            <div class="pull-right ml-2">
                                @if($data->res == null || $data->res == "")
                                    <a class="text-light btn btn-primary btn-xs response-btn">Response</a>
                                @endif
                            </div>
                            
                            <a  href="{{ route('complaints.index') }}" class="btn btn-primary btn-xs ml-auto">
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
                                                <th width="30%">Client:</th>
                                                <td>{{ isset($data->client->fullname) ? ($data->client->fullname) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ isset($data->client->email) ? ($data->client->email) : ""}}</td>
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
                                                <th width="30%">Contact#</th>
                                                <td>{{ isset($data->client->contact_no) ? ($data->client->contact_no) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th>lodged on:</th>
                                                <td>{{ isset($data->created_at) ? ($data->created_at) : ""}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tbody>
                                            <tr>
                                                <th width="15%">Subject:</th>
                                                <td>{{ isset($data->subject) ? ($data->subject) : ""}}</td>
                                            </tr>
                                            <tr>
                                                <th width="15%">Complaint:</th>
                                                <td>{{ isset($data->complaint) ? ($data->complaint) : ""}}</td>
                                            </tr>
                                            @if($data->res != null || $data->res != "")
                                            <tr>
                                                <th width="15%">Response:</th>
                                                <td>{{ isset($data->res) ? ($data->res) : ""}}</td>
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
