<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/icon.svg') }}" type="image/x-icon"/>
	<meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
	<!-- Fonts and icons ---->
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script src="{{asset('libs/jquery.min.js')}}" ></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ asset("assets/css/fonts.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files ---->
	<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> ---->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/azzara.min.css') }}">

	<!-- CSS Just for demo purpose, don't include it in your project ---->
	<!-- <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}"> ---->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.js" ></script> ---->
	<script src="{{ asset('assets/js/sweetalert2.all.js') }}" ></script>
	<style>
		.span_danger{
			color:red;
		}
		
		.add_image{
			position: relative;
		}
		.add_image label {
			position: absolute;
			top: 0;
			right: -5px;
			max-width: 10px;
			margin: 0;
		}
		.add_image input {
			opacity: 0;
			width: 0;
			height: 0;
		}
	      html,body{
	        height: 100%;
	      }
	      .loader{
	        display: none;
	      }
		.page-item.active .page-link {
		    z-index: 1;
		    color: #fff;
		    background-color: #1a1a1a !important;
		    border-color: #1a1a1a !important;
		}
		.sidebar .nav>.nav-item a i {
			margin-right: 15px;
			width: 25px;
			color: #000;
			text-align: center;
			vertical-align: middle;
			float: left;
		}
		.sidebar .nav>.nav-item.active a i {
		    color: #D63048;
		}	     
		.sidebar .nav>.nav-item a:focus i, .sidebar .nav>.nav-item a:hover i {
   	 		color: #D63048!important;
		} 
		.sidebar .nav>.nav-item a[data-toggle=collapse][aria-expanded=true]:before, .sidebar .nav>.nav-item.active:hover>a:before, .sidebar .nav>.nav-item.active>a:before {
		    background: #D63048;
		    opacity: 1!important;
		    position: absolute;
		    z-index: 1;
		    width: 3px;
		    height: 100%;
		    content: '';
		    left: 0;
		    top: 0;
		}
		select{
			padding-bottom: 5px !important;
		    padding-top: 5px !important;
		}
		/* The switch - the box around the slider */
		.switch {
		  position: relative;
		  display: inline-block;
		  width: 50px;
		  height: 25px;
		}

		/* Hide default HTML checkbox */
		.switch input {
		  opacity: 0;
		  width: 0;
		  height: 0;
		}

		/* The slider */
		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #df4759;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		   position: absolute;
		   content: "";
		   height: 15px;
		   width: 15px;
		   left: 6px;
		   bottom: 5px;
		   background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #42ba96;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #42ba96;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
		}

	</style>
</head>
<body>
	<div class="wrapper">
		<!--
			Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		---->
		<div class="main-header" data-background-color="light-blue">
			<!-- Logo Header ---->
			<div style="background:#000 !important;" class="logo-header">
				
				<a href="{{url('/home')}}" class="logo">
					<img src="{{ asset('assets/img/logo.png') }}" alt="navbar brand" class="navbar-brand" style= "width: 50%;
					margin-top: -20px;">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header ---->

			<!-- Navbar Header ---->
			<nav style="background:#1a1a1a !important;" class="navbar navbar-header navbar-light bg-white shadow-sm  navbar-expand-lg">
			<!-- navbar navbar-expand-md navbar-light bg-white shadow-sm ---->
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<!-- <form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form> ---->
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
					
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									@if(Auth::user()->profile_pic)
										<div class="avatar-lg"><img src="{{ asset('/uploads/users/'.Auth::user()->profile_pic) }}" alt="image profile" class="avatar-img rounded" style="width: 65%;height: 60%;"></div>
									@else
										<div class="avatar-lg"><img src="{{ asset('/uploads/no_image.png') }}" alt="image profile" class="avatar-img rounded" style="width: 65%;height: 60%;"></div>
									@endif
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<li>
									<div class="user-box">
										@if(Auth::user()->profile_pic)
											<div class="avatar-lg"><img src="{{ asset('/uploads/users/'.Auth::user()->profile_pic) }}" alt="image profile" class="avatar-img rounded" style="width: 65%;height: 60%;"></div>
										@else
											<div class="avatar-lg"><img src="{{ asset('/uploads/no_image.png') }}" alt="image profile" class="avatar-img rounded" ></div>
										@endif
										
										<?php $editLink = "users/".Auth::user()->id ."/edit";  ?>
										<!-- users/{{Auth::user()->id}}/edit ---->

										<div class="u-text">
											<h4>{{Auth::user()->name}}</h4>
											<p class="text-muted">{{Auth::user()->email}}</p><a  href="{{ url('users')}}/{{Auth::user()->id}}/edit"class="btn btn-rounded btn-danger btn-sm">View Profile</a>
										</div>
									</div>
								</li>
								<li>
								
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
														document.getElementById('logout-form').submit();">
										<i class="nav-icon fas fa-power-off"></i>
										{{ __('Logout') }}
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>

								</li>
							</ul>
						</li>
						
					</ul>
				</div>
			</nav>
			<!-- End Navbar ---->
		</div>

		<?php 
			function url_explode($url){
										
				$explodedUrl = explode("/", $url);
				if(is_array($explodedUrl)){
			
					if (count($explodedUrl) > 0)
					{
						$main = $explodedUrl[0];
						$state = "active";
						return $main;
					}
				}
			}
		?>
		<!-- Sidebar ---->
		<div class="sidebar">
			
			<div class="sidebar-background"></div>
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							@if(Auth::user()->profile_pic)
								<div class="avatar-lg"><img src="{{ asset('/uploads/users/'.Auth::user()->profile_pic) }}" alt="image profile" class="avatar-img rounded" style="width: 65%;height: 60%;"></div>
							@else
								<div class="avatar-lg"><img src="{{ asset('/uploads/no_image.png') }}" alt="image profile" class="avatar-img rounded" style="width: 65%;height: 60%;"></div>
							@endif
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{Auth::user()->name}}
									<span class="user-level">Administrator</span>
								</span>
							</a>
						</div>
					</div>
					<ul class="nav">

						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">General</h4>
						</li>
						
						<li class="nav-item  @if('home' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a href="{{url('/home')}}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>

						<li class="nav-item @if('orders' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/orders')}}">
								<i class="fab fa-first-order"></i>
								<p>Orders</p>
							</a>
						</li>

						<li class="nav-item @if('revisions' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/revisions')}}">
								<i class="fa fa-history"></i>
								<p>Revisions</p>
							</a>
						</li>

						<li class="nav-item @if('contests' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/contests')}}">
								<i class="fa fa-trophy"></i>
								<p>Contests</p>
							</a>
						</li>

                         <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">CUSTOMIZE</h4>
						</li>
						@if(Auth::user()->id == 1)
						
						<li class="nav-item @if('categories' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/categories')}}">
								<i class="fas fa-list-alt"></i>
								<p>Categories</p>
							</a>
						</li>

						<li class="nav-item @if('clients' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/clients')}}">
								<i class="fas fa-user"></i>
								<p>Clients</p>
							</a>
						</li>
						
						@endif

						<li class="nav-item @if('leaves' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/leaves')}}">
								<i class="fa fa-home"></i>
								<p>Leaves</p>
							</a>
						</li>


                         <li class="nav-item @if('feedbacks/create' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/feedbacks/create')}}">
								<i class="fas fa-comments"></i>
								<p>Feedback</p>
							</a>
						</li>
												
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">System</h4>
						</li> 
						

						<li class="nav-item @if('users' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/users')}}">
								<i class="fas fa-users"></i>
								<p>Users</p>
							</a>
						</li>


						<li class="nav-item @if('roles' == url_explode(request()->path()) ) {{'active'}} @endif">
							<a  href="{{url('/roles')}}">
								<i class="fas fa-key"></i>
								<p>Roles</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar ---->

		<div class="main-panel">
			<div class="content">
                @yield('content')
			</div>
		</div>
	</div>
</div>
<!--   Core JS Files   ---->
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<script src="{{asset('libs/datatable/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('libs/datatable/dataTables.bootstrap4.min.js')}}" defer></script>
<script src="{{asset('libs/jquery.validate.js')}}" defer></script>

<!-- jQuery UI ---->
<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<!-- <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script> ---->

<!-- jQuery Scrollbar ---->
<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- Moment JS ---->
<!-- <script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script> ---->

<!-- Chart JS ---->
<!-- <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script> ---->

<!-- jQuery Sparkline ---->
<!-- <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script> ---->

<!-- Chart Circle ---->
<!-- <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script> ---->

<!-- Datatables ---->
<!-- <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script> ---->

<!-- Bootstrap Notify ---->
<!-- <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script> ---->

<!-- Bootstrap Toggle ---->
<!-- <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script> ---->

<!-- jQuery Vector Maps ---->
<!-- <script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script> ---->

<!-- Google Maps Plugin ---->
<!-- <script src="{{ asset('assets/js/plugin/gmaps/gmaps.js') }}"></script> ---->

<!-- Sweet Alert ---->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Azzara JS ---->
<script src="{{ asset('assets/js/ready.min.js') }}"></script>

<!-- Azzara DEMO methods, don't include it in your project! ---->
<!-- <script src="{{ asset('assets/js/setting-demo.js') }}"></script>
<script src="{{ asset('assets/js/demo.js') }}"></script> ---->


    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click','.delete_all', function(e) {
                var id = $(this).data('id');
                    var allVals = [];
                        allVals.push($(this).attr('data-id'));

                if(allVals.length <=0)
                {
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select row!',
                    // footer: '<a href>Why do I have this issue?</a>'
                    })
                }  else {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        console.log(result.value);
                    var join_selected_values = allVals.join(",");

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $('#myTable').DataTable().ajax.reload();
                                

                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    data['success'],
                                    'success'
                                )

                            } else if (data['error']) {
                                // alert(data['error']);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data['error'],
                                })
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: "It is forign key of another entity, \n It cannot be deleted",
                                })
                            // alert(data.responseText);
                        }
                    });

                    } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                    ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary data is safe :)',
                        'error'
                    )
                    }
                })

                }
            });
        });
    </script>
 
</body>
</html>