<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/gg.png') }}">
    <title>.:: Login ::.</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
    @include('partials.styles')
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url(images/532.jpg);
            background-size: cover;
            background-position: center;
            font-family: sans-serif;
            height: 100vh;
            min-height: 380px;
        }

        .login-box {
            width: 320px;
            height: 380px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
            padding: 70px 30px;
        }

        .avatar {
            width: initial;
            height: 100px;
            /*border-radius: 50%;*/
            position: absolute;
            top: -50px;
            left: calc(43% - 50px);
        }

        h1 {
            margin: 0;
            padding: 0 0 20px;
            text-align: center;
            font-size: 22px;
        }

        .login-box p {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .login-box input {
            width: 100%;
            margin-bottom: 20px;
        }

        .login-box input[type="text"],
        input[type="password"] {
            border: none;
            border-bottom: 1px solid #fff;
            background: transparent;
            outline: none;
            height: 40px;
            color: #fff;
            font-size: 16px;
        }

        .login-box input[type="submit"] {
            border: none;
            outline: none;
            height: 40px;
            background: #1c8adb;
            color: #fff;
            font-size: 18px;
            border-radius: 20px;
        }

        .login-box input[type="submit"]:hover {
            cursor: pointer;
            background: #39dc79;
            color: #000;
        }

        .login-box a {
            text-decoration: none;
            font-size: 14px;
            color: #fff;
        }

        .login-box a:hover {
            color: #39dc79;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<?php
// $windows_user = shell_exec('wmic computersystem get username');
// $windows_user = shell_exec("wmic /node:$_SERVER[REMOTE_ADDR] COMPUTERSYSTEM Get UserName");
// $username = explode('\\', $windows_user)[1];
?>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">
        @if ($errors->any())
            <div class="p-3 mb-2 bg-danger text-white" align="center">{{ $errors->first() }}</div>
        @endif

        {{-- @if (session('info'))
            <div class="p-3 mb-2 bg-success text-white" align="center">
                {{ session('info') }}
            </div>
        @endif --}}
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="login-box">
                <div class="text-center">
                    <img src="{{ asset('images/gg.png') }}" class="avatar">
                </div>
                <h1 align="center">Login</h1>
                <form method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <p>Username</p>
                    {{-- <input type="text" name="username" readonly value="{{ $username }}"> --}}
                    {{-- <input type="submit" name="submit" value="Login" id="login-button"> --}}

                    <input type="text" name="username" placeholder="Enter Your Username"
                        class="{{ $errors->has('username') ? ' is-invalid' : '' }}" required="" autofocus=""
                        required oninvalid="this.setCustomValidity('Your Username Empty')"
                        oninput="setCustomValidity('')">
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Enter Your Password"
                        class="{{ $errors->has('password') ? ' is-invalid' : '' }}" required="" required
                        oninvalid="this.setCustomValidity('Your Password Empty')" oninput="setCustomValidity('')">
                    <input type="submit" name="submit" value="Login">

                    <span class="copyright">
                        <font size="2" font face="OptimusPrinceps.tff"><strong>&copy; 2019 PT. Gudang Garam
                                Tbk.
                                (Ver. 3.1)</strong></font>
                    </span>
                    <div class="col-md-12">

                    </div>
                </form><br>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#login-button").trigger('click');
    });
    $('#login-button').click(function() {
        $('#login-button').fadeOut("slow", function() {
            $("#container").fadeIn();
            TweenMax.from("#container", .4, {
                scale: 0,
                ease: Sine.easeInOut
            });
            TweenMax.to("#container", .4, {
                scale: 1,
                ease: Sine.easeInOut
            });
        });
    });

    $(".close-btn").click(function() {
        TweenMax.from("#container", .4, {
            scale: 1,
            ease: Sine.easeInOut
        });
        TweenMax.to("#container", .4, {
            left: "0px",
            scale: 0,
            ease: Sine.easeInOut
        });
        $("#container").fadeOut(800, function() {
            $("#login-button").fadeIn(800);
        });
    });
</script>
