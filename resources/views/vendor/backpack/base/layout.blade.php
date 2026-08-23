<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
      {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin' }}
    </title>

    @yield('before_styles')

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

    <!-- BackPack Base CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">

    @yield('after_styles')

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .cke_contents{
            height: 420px !important;
        }

      :root {
        --maf-black: #111111;
        --maf-red: #b22121;
        --maf-red-dark: #8f1b1b;
        --maf-ink: #202020;
        --maf-muted: #777777;
        --maf-line: #e5e5e5;
        --maf-paper: #f7f7f5;
      }

      html, body { background: var(--maf-paper); color: var(--maf-ink); font-family: Georgia, 'Times New Roman', serif; }
      .wrapper { min-height: 100vh; background: var(--maf-paper); }
      .main-header { background: var(--maf-black); box-shadow: 0 3px 12px rgba(0,0,0,.12); }
      .main-header .logo { background: var(--maf-black); color: #fff; font-size: 19px; letter-spacing: .04em; text-align: left; padding-left: 22px; }
      .main-header .logo:hover { background: var(--maf-black); }
      .main-header .navbar { background: var(--maf-black); }
      .main-header .sidebar-toggle { color: #fff; }
      .main-header .navbar-nav > li > a { color: #fff; font-family: Arial, sans-serif; font-size: 12px; letter-spacing: .08em; text-transform: uppercase; }
      .main-header .navbar-nav > li > a:hover { background: var(--maf-red); }
      .main-sidebar, .left-side { background: #181818; }
      .sidebar { padding-top: 14px; }
      .maf-admin-user { display: flex; align-items: center; gap: 11px; margin: 0 14px 18px; padding: 12px 0 17px; border-bottom: 1px solid rgba(255,255,255,.12); color: #fff; }
      .maf-admin-avatar { display: grid; place-items: center; width: 34px; height: 34px; border-radius: 50%; background: var(--maf-red); color: #fff; font: 600 14px Arial, sans-serif; }
      .maf-admin-user strong, .maf-admin-user span { display: block; }
      .maf-admin-user strong { font-size: 15px; font-weight: 400; }
      .maf-admin-user span { margin-top: 4px; color: #999; font: 10px Arial, sans-serif; text-transform: uppercase; letter-spacing: .08em; }
      .maf-admin-user span i { color: #78b56d; font-size: 7px; vertical-align: middle; }
      .sidebar-menu > li.header { padding: 16px 18px 7px; color: #777; font: 10px Arial, sans-serif; letter-spacing: .14em; }
      .sidebar-menu > li > a { padding: 11px 18px; color: #c9c9c9; font: 13px Arial, sans-serif; border-left: 3px solid transparent; }
      .sidebar-menu > li > a:hover, .sidebar-menu > li.active > a { color: #fff; background: rgba(178,33,33,.18); border-left-color: var(--maf-red); }
      .sidebar-menu > li > a > .fa { width: 22px; color: #999; }
      .sidebar-menu > li.active > a > .fa { color: #ef7777; }
      .content-wrapper { background: var(--maf-paper); }
      .content-header { padding: 25px 30px 12px; }
      .content-header h1 { color: var(--maf-black); font-size: 30px; font-weight: 400; letter-spacing: -.01em; }
      .content-header h1 small { color: var(--maf-muted); font: 12px Arial, sans-serif; }
      .breadcrumb { background: transparent; font: 11px Arial, sans-serif; }
      .breadcrumb a { color: var(--maf-red); }
      .content { padding: 12px 30px 35px; }
      .box { border: 1px solid var(--maf-line); border-top: 3px solid var(--maf-red); border-radius: 0; box-shadow: 0 7px 24px rgba(0,0,0,.05); }
      .box-header { padding: 17px 20px; background: #fff; }
      .box-body { padding: 20px; background: #fff; }
      .table { font-family: Arial, sans-serif; font-size: 12px; }
      .table > thead > tr > th { padding: 12px 10px; color: var(--maf-muted); border-bottom: 2px solid var(--maf-black); text-transform: uppercase; letter-spacing: .07em; font-size: 10px; }
      .table > tbody > tr > td { padding: 12px 10px; border-top: 1px solid #ededed; vertical-align: middle; }
      .table-striped > tbody > tr:nth-of-type(odd) { background: #fcfcfb; }
      .table-hover > tbody > tr:hover, .table-striped > tbody > tr:hover { background: #fff5f5; }
      .btn { border-radius: 2px; font-family: Arial, sans-serif; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; }
      .btn-primary, .btn-success { background: var(--maf-red); border-color: var(--maf-red); }
      .btn-primary:hover, .btn-success:hover { background: var(--maf-red-dark); border-color: var(--maf-red-dark); }
      .form-control, select.form-control { height: 40px; border: 1px solid #d8d8d8; border-radius: 2px; box-shadow: none; font-family: Arial, sans-serif; }
      textarea.form-control { min-height: 120px; }
      .form-control:focus { border-color: var(--maf-red); box-shadow: 0 0 0 2px rgba(178,33,33,.1); }
      label { color: #555; font: 11px Arial, sans-serif; letter-spacing: .05em; text-transform: uppercase; }
      .main-footer { background: var(--maf-black); border-top: 0; color: #999; font: 11px Arial, sans-serif; padding: 17px 30px; }
      @media (max-width: 767px) {
        .content-header { padding: 20px 15px 8px; }
        .content { padding: 10px 15px 25px; }
        .content-header h1 { font-size: 25px; }
        .box-body { padding: 12px; }
      }
    </style>
</head>
<body class="hold-transition {{ config('backpack.base.skin') }} sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">{!! config('backpack.base.logo_mini') !!}</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">{!! config('backpack.base.logo_lg') !!}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('backpack::base.toggle_navigation') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('backpack::inc.menu')
        </nav>
      </header>

      <!-- =============================================== -->

      @include('backpack::inc.sidebar')

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         @yield('header')

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        @if (config('backpack.base.show_powered_by'))
            <div class="pull-right hidden-xs">
              {{ trans('backpack::base.powered_by') }} <a href="http://laravelbackpack.com">Laravel BackPack</a>
            </div>
        @endif
        {{ trans('backpack::base.handcrafted_by') }} <a href="{{ config('backpack.base.developer_link') }}">{{ config('backpack.base.developer_name') }}</a>.
      </footer>
    </div>
    <!-- ./wrapper -->


    @yield('before_scripts')

    <!-- jQuery 2.2.0 -->
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('vendor/adminlte') }}/plugins/jQuery/jQuery-2.2.0.min.js"><\/script>')</script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <!-- page script -->
    <script type="text/javascript">

      function showPageLoader() {
          $.blockUI();
      }

      function hidePageLoader() {
          $.unblockUI();
      }

        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // Set active state on menu element
        var current_url = "{{ Request::url() }}";
        $("ul.sidebar-menu li a").each(function() {
          if ($(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')))
          {
            $(this).parents('li').addClass('active');
          }
        });
    </script>

    @include('backpack::inc.alerts')

    @yield('after_scripts')
</body>
</html>
