@extends('layouts.main')
@section('title','Dashboard')
	@section('content')
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h4 class="card-title">@yield('title')</h4>
						
						</div>
					</div>
					<div class="card-body">
					<div class="row">
							<div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body ">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-primary bubble-shadow-small">
													<i class="fab fa-first-order"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total Orders</p>
													<h4 class="card-title">{{ $orders ?? ''}}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-info bubble-shadow-small">
													<i class="far fa-user"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total Employes</p>
													<h4 class="card-title">{{ $users ?? '' }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@if(Auth::user()->id == 1)
                                <div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-success bubble-shadow-small">
													<i class="fas fa-user"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total client</p>
													<h4 class="card-title">{{ $clients ?? '' }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @else
                            <div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-success bubble-shadow-small">
													<i class="fa fa-trophy"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total Contests</p>
													<h4 class="card-title">{{ $contests ?? '' }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @endif
							@if(Auth::user()->id == 1)
                                <div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-secondary bubble-shadow-small">
													<i class="fa fa-money-check"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total Revenue</p>
													<h4 class="card-title">{{ $payments ?? '' }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @else
                            <div class="col-sm-6 col-md-3">
								<div class="card card-stats card-round">
									<div class="card-body">
										<div class="row align-items-center">
											<div class="col-icon">
												<div class="icon-big text-center icon-secondary bubble-shadow-small">
													<i class="fa fa-history"></i>
												</div>
											</div>
											<div class="col col-stats ml-3 ml-sm-0">
												<div class="numbers">
													<p class="card-category">Total Revisions</p>
													<h4 class="card-title">{{ $revisions ?? '' }}</h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>
@endsection