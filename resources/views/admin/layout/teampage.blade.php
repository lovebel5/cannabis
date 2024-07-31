<!DOCTYPE html>
<html lang="en">
<head>
    @include ('admin.layout.head')
</head>
<body class="animsition" style="opacity: 1">
<div class="page-wrapper">
    {{ csrf_field() }}
    @include ('admin.layout.menu')
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        @include ('admin.layout.top-menu')
    @yield('content')
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

</div>
<!-- Script -->
    @include('admin.layout.script')
<!-- END Script -->

</body>
</html>

