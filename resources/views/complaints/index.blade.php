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
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success d-none d-sm-inline-block">New Message</button>
                </div>

                <section class="card mt-4">
                    <div class="list-group list-group-messages list-group-flush">
                        <div class="list-group-item unread">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star1" value="1">
                                    <label for="star1">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Jimmy Denis</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> How are you? </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 16 minutes ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item unread">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star2" value="1" checked>
                                    <label for="star2">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-offline">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Chad</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Ok, Thanks ! </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 20 minutes ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-away">
                                        <img src="../assets/img/talha.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Talha</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Follow up this reminder asap, quam error praesentium asperiores a quidem. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 2 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-offline">
                                        <img src="../assets/img/mlane.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">John Doe</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Ready for the meeting today with client. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 2 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/arashmil.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Arash Mil</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Hi Guys, minus, aliquam porro repudiandae numquam. Molestias. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 3 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item unread">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star1" value="1">
                                    <label for="star1">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Jimmy Denis</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> How are you? </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 16 minutes ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item unread">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star2" value="1" checked>
                                    <label for="star2">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-offline">
                                        <img src="../assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Chad</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Ok, Thanks ! </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 20 minutes ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-away">
                                        <img src="../assets/img/talha.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Talha</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Follow up this reminder asap, quam error praesentium asperiores a quidem. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 2 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-offline">
                                        <img src="../assets/img/mlane.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">John Doe</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Ready for the meeting today with client. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 2 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
                        <div class="list-group-item read">
                            <div class="list-group-item-figure">
                                <span class="rating rating-sm mr-3">
                                    <input type="checkbox" id="star3" value="1">
                                    <label for="star3">
                                        <span class="fa fa-star"></span>
                                    </label>
                                </span>
                                <a href="conversations.html" class="user-avatar">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/arashmil.jpg" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                </a>
                            </div>
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-lg-10">
                                        <h4 class="list-group-item-title">
                                            <a href="conversations.html">Arash Mil</a>
                                        </h4>
                                        <p class="list-group-item-text text-truncate"> Hi Guys, minus, aliquam porro repudiandae numquam. Molestias. </p>
                                    </div>
                                    <div class="col-12 col-lg-2 text-lg-right">
                                        <p class="list-group-item-text"> 3 days ago </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item-figure">
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
                            </div>
                        </div>
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
