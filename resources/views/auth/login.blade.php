@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-color: #547c90;
            --sec-color: #265166;
            --acc-color: #f6fafd;
            --bg-color: #d0f1e6;
            --pungki: #f1dcd0;
            --meramera: #ca4c44;
            --birusepuh: #1e3745;
            --birupemula: #bacfda;
            --abusepuh: #414a4e;
        }

        .material-symbols-outlined {
            /* font-size: 24px; */
            padding: 0.7rem 0.9rem;
            background: var(--primary-color);
            color: var(--birupemula);
            border-radius: 2.3rem;
            margin-right: 0.5rem;
        }

        @media(max-width:768px) {
            .form-cont {
                background-color: rgba(255, 255, 255, 0.5);
                box-shadow: 0px 10px 30px rgba(30, 55, 69, 0.2);
                border-radius: 24px;
                border-bottom-left-radius: 24px !important;
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .form-control {
                border-radius: 12px;
                padding: 12px 20px;
                border: 1px solid #ddd;
                transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .form-control:focus {
                border-color: #0c0c0c;
                box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
            }

            .btn-login {
                background-color: #0c0c0c;
                border: none;
                border-radius: 24px;
                color: #f5f5f5;
                padding: 12px 20px;
                font-size: 16px;
                transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .btn-login span {
                display: none;
            }

            .btn-login i {
                margin-left: 0;
                font-size: 20px;
            }

            .btn-login {
                width: 40px;
                height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0;
                border-radius: 50%;
            }

            .btn-login:hover {
                background-color: #050505;
            }

            .btn-login i {
                margin-left: 4px;
                transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .btn-login:hover i {
                transform: translateX(10px);
            }

            .btn-link {
                color: #0c0c0c;
                text-decoration: none;
                transition: color 0.3s ease-in-out;
            }

            .form-check-input:checked {
                background-color: #0c0c0c;
                border-color: #0c0c0c;
            }

            .form-check-label {
                color: #333;
            }

            .img-container {
                height: 100% !important;
                position: relative;
                overflow: hidden;
                border-radius: 24px;
                border-top-right-radius: 24px !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            .img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(30, 55, 69, 0.7);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 20px;
                color: white;
                text-align: center !important;
            }

            .overlay-top {
                padding-top: 10% !important;
            }

            .overlay-bottom {
                display: none;
            }

            .overlay-top h2 {
                font-size: 2rem !important;
                font-weight: bold;
            }

            .overlay-top p {
                font-size: 1rem !important;
                font-weight: lighter;
            }
        }

        .form-cont {
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0px 10px 30px rgba(30, 55, 69, 0.2);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #0c0c0c;
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
        }

        .btn-login {
            background-color: #0c0c0c;
            border: none;
            border-radius: 24px;
            color: #f5f5f5;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn-login:hover {
            background-color: #050505;
        }

        .btn-login i {
            margin-left: 4px;
            transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn-login:hover i {
            transform: translateX(10px);
        }

        .btn-link {
            color: #0c0c0c;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .form-check-input:checked {
            background-color: #0c0c0c;
            border-color: #0c0c0c;
        }

        .form-check-label {
            color: #333;
        }

        .img-container {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30, 55, 69, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            color: white;
            text-align: right;
        }

        .overlay-top {
            padding-top: 20%;
        }

        .overlay-top h2 {
            font-size: 3rem;
            font-weight: bold;
        }

        .overlay-top p {
            font-size: 1.2rem;
            font-weight: lighter;
        }

        .overlay-bottom h2 {
            font-size: 1.7rem;
            font-weight: bold;
        }

        .overlay-bottom p {
            font-size: 0.9rem;
            font-weight: lighter;
        }

        input::placeholder {
            font-style: italic;
        }

        #pwDiv i {
            opacity: 0;
            transform: translateY(-6px) rotate(0deg);
            transition: all 0.3s ease-in-out;
        }

        #pwDiv:hover i,
        #pwDiv i.active opacity: 1;
        transform: translateY(0) rotate(360deg);
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100 d-flex justify-content-center h-75">
            <div class="p-0 col-md-6 col-12" style="z-index: 999;">
                <div class="img-container">
                    <img src="https://www.logility.com/wp-content/uploads/2023/05/Unlocking-the-power-of-Inventory-Control-Techniques-Header-1.png"
                        alt="login-img">
                    <div class="overlay">
                        <div class="overlay-top">
                            <h2>
                                Inventory
                            </h2>

                            <p>Website Inventory Micro Controller</p>

                            <hr>
                        </div>
                        <div class="overlay-bottom">
                            <h2>Chill guy</h2>
                            <p>Contact: +62 876 5432 1098</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 col-md-6 col-12 form-cont text-star"
                style="margin-left: -1%; border-radius: 24px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                <h2 class="mb-4" style="color: #333;">Login to Your Account</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4 input-group">
                        <span class="material-symbols-outlined">person</span>
                        <input id="username" type="text"
                            style="border-radius: 24px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                            class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div id="pwDiv" class="mb-4 input-group" style="position: relative;">
                        <span class="material-symbols-outlined">password</span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            style="border-radius: 24px; border-top-left-radius: 0; border-bottom-left-radius: 0; padding-right: 40px;"
                            name="password" required autocomplete="current-password" placeholder="Password">

                        <i id="togglePassword" class="fas fa-eye"
                            style="color: #0c0c0c; z-index:9999;position: absolute; right: 1rem; top: 50%; transform: translateY(-6px); transition: all 0.3s ease-in-out; cursor: pointer;"></i>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mx-2 mb-4 input-group row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button type="submit" class="btn btn-login w-50">
                                <span>{{ __('Login') }}</span> <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            let passwordField = document.getElementById("password");
            let icon = this;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }

            icon.classList.toggle("active");
        });
    </script>
@endsection
