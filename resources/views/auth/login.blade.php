<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form sliding</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="container">
        <div class="box signin">
            <h2>Already have an account?</h2>
            <button class="signinBtn">Sign in</button>
        </div>

        <div class="box signup">
            <h2>Don't have an account?</h2>
            <button class="signupBtn">Sign up</button>
        </div>

        <!-- Signin Form -->
        <div class="formBx">
            <div class="form signinform">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3>Sign In</h3>
                    <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    <input type="password" name="password" placeholder="Password" required> 
                    <input type="submit" value="Login">  
                    <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
                    
                    @if ($errors->any())
                        <div class="error-messages">
                            @foreach ($errors->all() as $error)
                                <p style="color: red;">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

            <!-- Signup Form -->
            <div class="form signupform">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3>Sign Up</h3>
                    <input type="text" name="name" placeholder="Nom" value="{{ old('name') }}" required>
                    <input type="text" name="prenom" placeholder="Prenom" value="{{ old('prenom') }}" required>
                    <input type="text" name="tel" placeholder="Tel" value="{{ old('tel') }}" required>
                    <input type="email" name="email" placeholder="E-mail address" value="{{ old('email') }}" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required> 
                    <input type="submit" value="Register">
                    
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <script>
        let signinBtn = document.querySelector('.signinBtn');
        let signupBtn = document.querySelector('.signupBtn');
        let body = document.querySelector('body');

        signupBtn.onclick = function(){
            body.classList.add('slide');
        }
        signinBtn.onclick = function(){
            body.classList.remove('slide');
        }
    </script>

