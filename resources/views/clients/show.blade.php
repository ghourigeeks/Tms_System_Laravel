@extends('layouts.main')
@section('title','Client')
@section('content')
    @include( '../sweet_script')
    
    <div class="page-inner">
        <h4 class="page-title">@yield('title') Profile</h4>
        <div class="row row-card-no-pd">
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-box text-success" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($boxes))  && ($boxes > 0) )
                                            <a href="{{ url('clients')}}/boxes/{{$data->id}}"> Boxes</a>
                                        @else
                                            Boxes
                                        @endif
                                    </p>
                                    <h4 class="card-title">{{ isset($boxes) ? ($boxes) : 0}} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fab fa-product-hunt text-primary" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($products))  && ($products > 0) )
                                            <a href="{{ url('clients')}}/products/{{$data->id}}"> Products</a>
                                        @else
                                            Products
                                        @endif
                                    </p>
                                    <h4 class="card-title"> {{ isset($products) ? ($products) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-microchip text-danger" style="font-size:2.4rem"></i>
                                </div>
                            </div>
                            <div class="col col-stats">
                                <div class="numbers">
                                    <p class="card-category">
                                        @if((isset($ibeacons))  && ($ibeacons > 0) )
                                            <a href="{{ url('clients')}}/ibeacons/{{$data->id}}"> Ibeacons</a>
                                        @else
                                            Ibeacons
                                        @endif
                                    <h4 class="card-title"> {{ isset($ibeacons) ? ($ibeacons) : 0}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
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
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table dt-responsive">
                                        <tr>
                                            <th width="40%">Full name</th>
                                            <td>
                                                {{$data->fullname}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>
                                                {{ isset($data->address) ? ($data->address) :""}} ,
                                                {{ isset($data->city) ? ($data->city) :""}} ,
                                                {{ isset($data->state) ? ($data->state) :""}} 
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Country & Region</th>
                                            <td>
                                                {{ isset($data->country->name) ? ($data->country->name) :""}} ,
                                                {{ isset($data->region->name) ? ($data->region->name) :""}} 
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Phone#</th>
                                            <td>
                                                {{ isset($data->phone_no) ? ($data->phone_no) :""}} 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Package subscription</th>
                                            <td>
                                                {{ isset($detail->address) ? ($detail->address) :""}}
                                            </td>
                                        </tr>
                                        <br>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card card-profile card-secondary">
                    <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="<?php echo $data->profile_pic ?>" alt="" class="avatar-img rounded-circle"  style="width:80px; height:80px">
                                <!-- <img src="{{ $data->profile_pic}}" alt="..." class="avatar-img rounded-circle"  style="width:80px; height:80px"> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">
                                {{ucwords($data->fname)}} 
                                @if(isset($data->verified) && $data->verified == 0 )
                                    <i class="fas fa-times-circle" style="color:red;font-size:24px" data-toggle="tooltip" data-placement="top" title="Non-verified Profile"></i>
                                @else
                                    <i class="fas fa-check-circle" style="color:#4AD24E;font-size:24px" data-toggle="tooltip" data-placement="top" title="Verified Profile"></i>
                                @endif 
                            </div>
                            <div class="name">{{  isset($data->email) ? ($data->email) : "" }}</div>
                            <div class="job">{{  isset($data->phone_no) ? ($data->phone_no) : "" }}</div>
                            <div class="job">{{(isset($data->username) ? ($data->username) : "")}}</div>
                          
                            
                            <!-- <div class="desc">A man who hates loneliness</div> -->
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                                    <span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

    <!-- Creates the bootstrap modal where the image will appear -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <!-- <h4 class="modal-title" id="myModalLabel">Image preview</h4> -->
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 468px; height: 264px;" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".pop").on("click", function() {
            $('#imagepreview').attr('src',$(this).find(".imageresource").attr('src'));
            $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });


    </script>
  
@endsection
