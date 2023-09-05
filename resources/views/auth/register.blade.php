<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}" />
    <title>Register</title>
</head>
<body>
    <div class="register-logo-container">
        <img class="auth-logo" src="{{ asset('images/logo.png')}} " alt="AE LOGO">
    </div>
    <div class="authForm">
        <form action="{{route('auth.register')}}" method="post">
            @csrf
            <h2> Create Account </h2>
            <div class="field">
                <input type="text" id="name" name="name" required>
                <label>Name</label>
                <span>Name</span>
                <!-- Display error message for name -->
                @if ($errors->has('name'))
                    <p class="warning-response">{{ $errors->first('name') }}</p>
                @endif
            </div>
            <div class="field">
                <input type="email" id="email" name="email" required>
                <label>Email</label>
                <span>Email</span>
                <!-- Display error message for email -->
                @if ($errors->has('email'))
                    <p class="warning-response">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="field">
                <input type="password" id="password" name="password" required>
                <label>Password</label>
                <span>Password</span>
                <!-- Display error message for password -->
                @if ($errors->has('password'))
                    <p class="warning-response">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="field">
                <input type="password" id="confirm-password" name="password_confirmation" required>
                <label>Confirm Password</label>
                <span>Confirm Password</span>
            </div>
            <p class="has-account">Already have an account? <a href="{{route('login')}}">Login</a></p>
            <input type="submit" value="Sign Up">
        </form>
    </div>
    @if ($errors->has('error'))
    <span class="warning-response" role="alert">
        <strong>{{ $errors->first('error') }}</strong>
    </span>
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
    <script type="module" src="{{asset('js/auth/registerValidation.js')}}"></script>
</body>
</html>

