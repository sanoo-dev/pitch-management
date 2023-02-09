<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin - Dashboard')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  @yield('css')
  <style>
    html {
      font-size: 14px;
    }

    .content-wrapper{
        background-image: url(https://haycafe.vn/wp-content/uploads/2022/01/Hinh-nen-mau-trang-kem.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  @include('sweetalert::alert')
  <div class="wrapper">

    <!-- Navbar -->
    @include('components.admin.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('components.admin.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        @yield('content-header')
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        @yield('main-content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{--  <!-- Footer -->
    @include('components.admin.footer')
    <!-- /.footer -->  --}}
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  {{-- <script>
        $.widget.bridge('uibutton', $.ui.button);

    </script> --}}
  <!-- Bootstrap 4 -->
  <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
  <!-- Bootstrap Switch -->
  <script src="{{ asset('backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

  {{-- Fix active sidebar --}}
  <script>
    $(document).ready(function() {
      /** add active class and stay opened when selected */
      var url = window.location;
      // for sidebar menu entirely but not cover treeview
      $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
      }).addClass('active');
      // for treeview
      $('ul.nav-treeview a').filter(function() {
        return this.href == url;
      }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
    })

  </script>

  @yield('js')
</body>
</html>
