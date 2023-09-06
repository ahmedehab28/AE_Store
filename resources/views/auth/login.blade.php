<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}" />
    <title>Login</title>
</head>
<body>
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="login-logo-container">
        <img class="auth-logo" src="{{ asset('images/logo.png')}} " alt="AE LOGO">
    </div>
    <div class="authForm">
        <form action="{{ route('auth.login') }}" method="post">
            @csrf
            <h2>Sign In</h2>
            <div class="field">
                <input type="email" id="email" name="email" required>
                <label>Email</label>
                <span>Email</span>
            </div>
            <div class="field">
                <input type="password" id="password" name="password" required>
                <label>Password</label>
                <span>Password</span>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember-me">Remember me</label>
            </div>
            <p>You don't have an account? <a href="{{ route('register')}}">Sign Up</a></p>
            <input type="submit" value="Sign In">
        </form>
    </div>


    {{-- Displaying Errors --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="warning-response" role="alert">
                <strong>{{ $error }}</strong>
            </span>
        @endforeach
    @endif


    <div class="footer-container">
        <div class="col">
          <a href="">Menu links</a>
        </div>

        <div class="col">
          <a href="">Our services</a>
        </div>

        <div class="col">
          <a href="">Information</a>
        </div>

        <div class="col">
          <a href="">Contact Us</a>
        </div>
    </div>

    <script src="{{ asset('js/auth/animation.js') }}"></script>
    <script src="{{ asset('js/auth/loginValidation.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>

