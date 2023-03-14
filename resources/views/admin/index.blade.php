@extends('layout.admin')

@section('title', 'Admin - Warung Kopi Gowes')

@section('content')
    
    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
          <!--overview start-->
          <div class="row">
            <div class="col-lg-12">
              <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ route('admin.index') }}">Home</a></li>
                <li><i class="fa fa-laptop"></i>Dashboard</li>
              </ol>
            </div>
          </div>
  
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="info-box blue-bg">
                <i class="fa fa-users"></i>
                <div class="count">{{ $total_user }}</div>
                <div class="title">Total Users</div>
              </div>
              <!--/.info-box-->
            </div>
            <!--/.col-->
  
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="info-box brown-bg">
                <i class="fa fa-truck"></i>
                <div class="count">{{ $total_shipping }}</div>
                <div class="title">Shipping</div>
              </div>
              <!--/.info-box-->
            </div>
            <!--/.col-->
  
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="info-box dark-bg">
                <i class="fa fa-shopping-cart"></i>
                <div class="count">{{ $total_order }}</div>
                <div class="title">Order</div>
              </div>
              <!--/.info-box-->
            </div>
            <!--/.col-->
  
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="info-box green-bg">
                <i class="fa fa-dollar"></i>
                <div class="count">{{ $total_purchased }}</div>
                <div class="title">Purchased</div>
              </div>
              <!--/.info-box-->
            </div>
            <!--/.col-->
  
          </div>
          <!--/.row-->
  
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  User Checkout
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th>Payment ID</th>
                        <th>User ID</th>
                        <th>Price Total</th>
                        <th>Payment Type</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($user_checkout as $row)    
                        <tr>
                          <td>{{ $row->payment_id }}</td>
                          <td>{{ $row->user_id }}</td>
                          <td>{{ $row->price_total }}</td>
                          <td>{{ $row->payment_total }}</td>
                          <td>{{ $row->status }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="justify-content-center">
                    {{ $user_checkout->links('pagination::bootstrap-4') }}
                  </div>
                </div>
  
              </section>
            </div>
          </div>
      </section>
      <!--main content end-->
    </section>
    <!-- container section start -->

@endsection

@section('js')
    
    <!-- chartjs -->
    <script src="{{ asset('asset2/assets/chart-master/Chart.js') }}"></script>
    <!-- custom chart script for this page only-->
    <script>
      $(document).ready(function() {

        var lineChartData = {
            labels : ["a","b","c","d","e","f","g"],
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    data : [65,59,90,81,56,55,40]
                },
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data : [28,48,40,19,96,27,100]
                }
            ]

        };
        var barChartData = {
            labels : ["January","February","March","April","May","June","July"],
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    data : [65,59,90,81,56,55,40]
                },
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    data : [28,48,40,19,96,27,100]
                }
            ]

        };

        new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
        new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
        
      });
    </script>

@endsection