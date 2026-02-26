<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/register5.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 24 Feb 2026 10:26:05 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
     <link rel="stylesheet" href="{{ asset('admin/auth/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/auth/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/auth/css/iofrm-style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/auth/css/iofrm-theme5.css') }}">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="{{ asset('admin/auth/images/logo-light.svg')}}" alt="">
                </div>
            </a>
        </div>
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="{{asset('admin/auth/images/graphic2.svg')}}" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Get more things done with Loggin platform.</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <div class="page-links">
                            <a href="{{route('auth.login')}}">Login</a><a href="{{route('auth.register')}}" class="active">Register</a>
                        </div>
                        <form action="{{route('auth.postRegister')}}" method="post">
                            @csrf
                             <div>
                                <label for="name">Name</label>
                                <input class="form-control" type="name" name="name" placeholder="Name" required>
                            </div>
                           <div>
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
                            </div>
                            <div>
                                <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>

                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Register</button>
                            </div>
                        </form>
                        <div class="other-links">
                            <span>Or register with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('admin/auth/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/auth/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/auth/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/auth/js/main.js') }}"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"a5ac555be5164e80beebf0126c78cafd","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from brandio.io/envato/iofrm/html/register5.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 24 Feb 2026 10:26:05 GMT -->
</html>