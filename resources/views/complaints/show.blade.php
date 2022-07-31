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
                                <button class="btn btn-secondary" type="button">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="card mt-4">
                    <div class="list-group list-group-messages list-group-flush">
                        @foreach($complaints as $key => $complaint)
                            <div class="list-group-item unread">
                                <div class="list-group-item-figure">
                                    <a href="{{route('complaints.show',$complaint->id)}}" class="user-avatar">
                                        <div class="avatar avatar-online">
                                            <img src="{{$complaint->clients->profile_pic}}" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                </div>
                                <div class="list-group-item-body pl-3 pl-md-4">
                                    <div class="row">
                                        <div class="col-12 col-lg-10">
                                            <h4 class="list-group-item-title">
                                                <a href="{{route('complaints.show',$complaint->id)}}">{{$complaint->clients->fullname}}</a>
                                            </h4>
                                            <p class="list-group-item-text text-truncate"> {{Str::of($complaint->subject)->limit(30)}} </p>
                                        </div>
                                        <div class="col-12 col-lg-2 text-lg-right">
                                            <p class="list-group-item-text"> {{$complaint->created_at}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                  <!--Pagination here-->
                </div>
            </div>
    @endsection
