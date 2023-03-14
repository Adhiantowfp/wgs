<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="{{ asset('asset2/img/avatar-mini.jpg')}} ">

  <title>@yield('title')</title>
  <link href="{{asset('asset2/css/style.css')}}" rel="stylesheet">
  <!-- Multiple -->
  <script src="{{asset('asset2/js/jquery.js')}}"></script>
  <script src="{{asset('asset2/js/jquery-ui-1.10.4.min.js')}}"></script>
  <script src="{{asset('asset2/js/jquery-1.8.3.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('asset2/js/jquery-ui-1.9.2.custom.min.js')}}"></script>
  <link href="{{asset('asset2/css/chosen.css')}}" rel="stylesheet">
  <script src="{{asset('asset2/js/chosen.js')}}"></script>
  <!-- Bootstrap CSS -->
  <link href="{{asset('asset2/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="{{asset('asset2/css/bootstrap-theme.css')}}" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="{{asset('asset2/css/elegant-icons-style.css')}}" rel="stylesheet" />
  <link href="{{asset('asset2/css/font-awesome.min.css')}}" rel="stylesheet" />
  <!-- full calendar css-->
  <link href="{{asset('asset2/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css')}}" rel="stylesheet" />
  <link href="{{asset('asset2/assets/fullcalendar/fullcalendar/fullcalendar.css')}}" rel="stylesheet" />
  <!-- easy pie chart-->
  <link href="{{asset('asset2/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" rel="stylesheet" type="text/css" media="screen" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="{{asset('asset2/css/owl.carousel.css')}}" type="text/css">
  <link href="{{asset('asset2/css/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{asset('asset2/css/fullcalendar.css')}}">
  <link href="{{asset('asset2/css/widgets.css')}}" rel="stylesheet">
  
  <link href="{{asset('asset2/css/style-responsive.css')}}" rel="stylesheet" />
  <link href="{{asset('asset2/css/xcharts.min.css')}}" rel=" stylesheet">
  <link href="{{asset('asset2/css/jquery-ui-1.10.4.min.css')}}" rel="stylesheet">
  <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">


    <header class="header">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="{{ route('admin.index') }}" class="logo">Warung Kopi <span class="lite">Gowes</span></a>
      <!--logo end-->

      <div class="nav search-row" id="top_menu">
        <!--  search form start -->
        <ul class="nav top-menu">
          <li>
            <form class="navbar-form">
              <input class="form-control" placeholder="Search" type="text">
            </form>
          </li>
        </ul>
        <!--  search form end -->
      </div>

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
          <!-- user login dropdown start-->
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="profile-ava">
                <img alt=""  style="width: 35px; height: 35px;" src="{{ url('https://ui-avatars.com/api/?name=' . $data->name . '&color=7F9CF5&background=EBF4FF') }}">
              </span>
              <span class="username">{{ $data->name }}</span>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
                <li>
                  <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon_key_alt"></i> Logout</a>
                  
                  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">

                    @csrf

                  </form>
                </li>
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
            <a class="" href="{{ route('admin.index') }}">
              <i class="icon_house_alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_cart"></i>
              <span>Store</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('admin.store.data-items') }}">Data Items</a></li>
              <li><a class="" href="{{ route('admin.store.make-items') }}">Make Items</a></li>
              <li><a class="" href="{{ route('admin.store.payment-items') }}">Payment Items</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
              <i class="icon_piechart"></i>
              <span>User</span>
              <span class="menu-arrow arrow_carrot-right"></span>
            </a>
            <ul class="sub">
              <li><a class="" href="{{ route('admin.user.data') }}">Data Users</a></li>
              <li><a class="" href="{{ route('admin.user.checkout') }}">Checkout Users</a></li>
            </ul>
          </li>

        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    @yield('content')

  <!-- javascripts -->
  
  <!-- bootstrap -->
  <script src="{{asset('asset2/js/bootstrap.min.js')}}"></script>
  <!-- nice scroll -->
  <script src="{{asset('asset2/js/jquery.scrollTo.min.js')}}"></script>
  <script src="{{asset('asset2/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="{{asset('asset2/assets/jquery-knob/js/jquery.knob.js')}}"></script>
  <script src="{{asset('asset2/js/jquery.sparkline.js')}}" type="text/javascript"></script>
  <script src="{{asset('asset2/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
  <script src="{{asset('asset2/js/owl.carousel.js')}}"></script>
  <!-- jQuery full calendar -->
  <<script src="{{asset('asset2/js/fullcalendar.min.js')}}"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="{{asset('asset2/assets/fullcalendar/fullcalendar/fullcalendar.js')}}"></script>
    <!--script for this page only-->
    <script src="{{asset('asset2/js/calendar-custom.js')}}"></script>
    <script src="{{asset('asset2/js/jquery.rateit.min.js')}}"></script>
    <!-- custom select -->
    <script src="{{asset('asset2/js/jquery.customSelect.min.js')}}"></script>
    <script src="{{asset('asset2/assets/chart-master/Chart.js')}}"></script>

    <!--custome script for all page-->
    <script src="{{asset('asset2/js/scripts.js')}}"></script>
    <!-- custom script for this page-->
    <script src="{{asset('asset2/js/sparkline-chart.js')}}"></script>
    <script src="{{asset('asset2/js/easy-pie-chart.js')}}"></script>
    <script src="{{asset('asset2/js/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('asset2/js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('asset2/js/xcharts.min.js')}}"></script>
    <script src="{{asset('asset2/js/jquery.autosize.min.js')}}"></script>
    <script src="{{asset('asset2/js/jquery.placeholder.min.js')}}"></script>
    <script src="{{asset('asset2/js/gdp-data.js')}}"></script>
    <script src="{{asset('asset2/js/morris.min.js')}}"></script>
    <script src="{{asset('asset2/js/sparklines.js')}}"></script>
    <script src="{{asset('asset2/js/charts.js')}}"></script>
    <script src="{{asset('asset2/js/jquery.slimscroll.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script>
    @yield('js')

</body>

</html>
