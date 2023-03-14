@extends('layout.admin')

@section('title', 'Admin - Warung Kopi Gowes')

@section('content')
    
    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
          <!--overview start-->
          <div class="row">
            <div class="col-lg-12">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="page-header"><i class="fa fa-th-list"></i> User Checkout</h3>
                </div>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ route('admin.index') }}">Home</a></li>
                <li><i class="fa fa-th-list"></i>User Checkout</li>
              </ol>
            </div>
          </div>

          @if (session('message_success'))

            <div class="alert alert-success fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
                                  <i class="icon-remove"></i>
                              </button>
              <strong>{{ session('message_success') }}</strong>
            </div>
                
          @endif
            
          @if (session('message_fail'))

            <div class="alert alert-block alert-danger fade in">
              <button data-dismiss="alert" class="close close-sm" type="button">
                                  <i class="icon-remove"></i>
                              </button>
              <strong>{{ session('message_fail') }}</strong>
            </div>
              
          @endif

          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  User  Checkout
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">Payment ID</th>
                        <th class="text-center">User ID</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Quantity</th>
                        <th class="text-center">Price Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $row)
                            <tr style="text-align: center">
                                <td>{{ $row->payment_id }}</td>
                                <td>{{ $row->user_id }}</td>
                                @php
                                    $product_name = [];
                                    foreach (explode(', ',$row->product_id) as $id) {
                                        $user_data = collect(DB::select("select * from items where product_id = '". $id . "'"))->first();
                                        array_push($product_name, $user_data->product_name);
                                    }
                                @endphp
                                <td>
                                    @foreach ($product_name as $p_name)
                                        <p>{{ $p_name }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach (explode(', ', $row->product_quantity) as $p_qty)
                                        <p>{{ $p_qty }}</p>
                                    @endforeach
                                </td>
                                <td>Rp. {{ number_format($row->price_total) }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ date('d M Y, H:i',strtotime($row->updated_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
  
              </section>
            </div>
          </div>

        </section>
    </section>
    <!--main content end-->

@endsection

@section('js')
    
    <script>
      $(".delete").click(function () {
            var id = $(this).data('id')
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                    $("#delete" + id).submit();
                }
            });
        })
        
        $(".success").click(function () {
            var id = $(this).data('id')
            swal({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success",
                button: "Close",
            })
            .then((success) => {
                if (success) {
                    $("#success" + id).submit();
                }
            });
        })
    </script>

@endsection