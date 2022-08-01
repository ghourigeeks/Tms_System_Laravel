@extends('layouts.main')
@section('title','Complaints')
@section('content')
    @include( '../sweet_script')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div class="d-md-inline-block">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white">
                                    <i class="fa fa-search search-icon"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with dropdown button">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" >Search</button>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn btn-success d-none d-sm-inline-block">New Message</button> -->
                </div>

                <section class="card mt-4">
                    <div class="list-group list-group-messages list-group-flush">
                        @foreach($complaints as $key => $complaint)
                            <div class="list-group-item unread">
                                <div class="list-group-item-figure">
                                    <a href="{{route('complaints.show',$complaint->id)}}" class="user-avatar">
                                        <div class="avatar">
                                            <img src="{{$complaint->client->profile_pic}}" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                </div>
                                <div class="list-group-item-body pl-3 pl-md-4">
                                    <div class="row">
                                        <div class="col-12 col-lg-10">
                                            <h4 class="list-group-item-title">
                                                <a href="{{route('complaints.show',$complaint->id)}}">
                                                    @if(isset($complaint->client->fullname))
                                                        {{$complaint->client->fullname}} 
                                                    @endif
                                                </a>
                                            </h4>
                                            <p class="list-group-item-text text-truncate">
                                                @if(isset($complaint->subject))
                                                    {{Str::of($complaint->subject)->limit(30)}} 
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-2 text-lg-right">
                                            <p class="list-group-item-text"> 
                                                @if(isset($complaint->created_at))
                                                    {{$complaint->created_at}} 
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="list-group-item-figure">
                                    <div class="dropdown">
                                        <button class="btn-dropdown" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-arrow"></div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">Mark as read</a>
                                            <a href="#" class="dropdown-item">Mark as unread</a>
                                            <a href="#" class="dropdown-item">Toggle star</a>
                                            <a href="#" class="dropdown-item">Trash</a>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="mt-1 mb-2">
                    <p class="text-muted"> Showing 1 to 10 of 1,000 entries </p>
                    <ul class="pagination justify-content-center mb-5 mb-sm-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fa fa-lg fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">13</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">14</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">15</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">24</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fa fa-lg fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
