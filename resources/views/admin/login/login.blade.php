@extends('layout.auth')

@section('title', 'Admin - Login')

@section('content')
    
<div class="container">

    <form class="login-form" method="POST" action="{{ route('admin.signin') }}">
      
      @csrf
      
      <div class="login-wrap">
        <p class="login-img"><i class="fa fa-user"></i></p>
        
        @if (session('message_success'))

        <div class="alert alert-success fade in">
          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                          </button>
          <strong>{{ session('message_success') }}</strong>
        </div>
            
        @endif
        
        @if (session('message_fail'))

        <div class="alert alert-block alert-danger fade in">
          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                          </button>
          <strong>{{ session('message_fail') }}</strong>
        </div>
            
        @endif
        
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" autofocus>
          
          @error('username')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror

        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
        
          @error('password')
              <div class="invalid-feedback">{{ $messagephp }}</div>
          @enderror

        </div>
        <label class="checkbox">
            <input type="checkbox" value="remember-me" name="remember"> Remember me
        </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
      </div>
    </form>
  </div>

@endsection