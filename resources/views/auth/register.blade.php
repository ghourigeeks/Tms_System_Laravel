@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group form-floating-label">
                            <input id="name" name="name" type="text" class="form-control input-border-bottom @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus >
                            <label for="name" class="placeholder">Name</label>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-floating-label">
                            <input id="email" name="email" type="text" class="form-control input-border-bottom @error('email') is-invalid @enderror" value="{{ old('email') }}" required  autocomplete="name">
                            <label for="email" class="placeholder">E-Mail Address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-floating-label">
                            <input id="password" type="password"  class="form-control input-border-bottom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" >
                            <label for="username" class="placeholder">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-floating-label">
                            <input id="password" type="password"  class="form-control input-border-bottom @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                            <label for="username" class="placeholder">Confirm Password</label>
                            @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
