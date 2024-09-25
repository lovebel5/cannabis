<!DOCTYPE html>
<html lang="en">
<head>
    @include ('admin.layout.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="page-wrapper">

<!-- PAGE CONTAINER-->
        <main class="login-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>
                            <div class="card-body">
                                <form action="" method="">
                                    <div class="form-group row">
                                        <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
                                            <input type="text" id="email_address" class="form-control" name="email-address" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" name="password" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember"> Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                        <a href="#" class="btn btn-link">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                            {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    </main>

    <!-- END PAGE CONTAINER-->
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <p>Copyright © 2022 Colorlib. All rights reserved. Template by <a
                            href="https://fb.com/ohnobel" target="_blank">OHno Bel</a>.</p>
                </div>
            </div>
        </div>
    </div>

<!-- Script -->
@include('admin.layout.script')
<!-- END Script -->

</body>
</html>
