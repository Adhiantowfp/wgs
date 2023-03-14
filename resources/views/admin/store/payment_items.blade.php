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
                    <h3 class="page-header"><i class="fa fa-th-list"></i> Data Items</h3>
                    <a class="btn btn-default" data-toggle="modal" href="#myModal" title="Bootstrap 3 themes generator"><i class="fa fa-pencil-square-o"></i> Make Payment</a>
                </div>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ route('admin.index') }}">Home</a></li>
                <li><i class="fa fa-th-list"></i>Data Items</li>
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
                  Payment List
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">Payment Type</th>
                        <th class="text-center">Account Name</th>
                        <th class="text-center">Account Number</th>
                        <th class="text-center">Total</th>
                        {{-- <th class="text-center">Aksi</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_list as $payment)    
                            <tr style="text-align: center">
                                <td>{{ $payment->payment_type }}</td>
                                <td>{{ $payment->account_name }}</td>
                                <td>{{ $payment->account_number }}</td>
                                <td>{{ $payment->total }}</td>
                                {{-- <td>
                                    <div class="btn-group">
                                        <a class="btn btn-success" href="#"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="btn btn-danger" href="#"><i class="fa fa-trash"></i></a>
                                      </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="justify-content-center">
                    {{ $payment_list->links('pagination::bootstrap-4') }}
                  </div>
                </div>
  
              </section>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  Payment Verify
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">Payment ID</th>
                        <th class="text-center">User ID</th>
                        <th class="text-center">Price Total</th>
                        <th class="text-center">Image Payment</th>
                        <th class="text-center">Payment Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($payment_verify as $row)
                        <tr style="text-align: center">
                            <td>{{ $row->payment_id }}</td>
                            <td>{{ $row->user_id }}</td>
                            <td>Rp. {{ number_format($row->price_total) }}</td>
                            <td><a href="{{ asset($row->image_payment) }}" target="__blank">View</a></td>
                            <td>{{ $row->payment_type }}</td>
                            <td>{{ $row->status }}</td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-success success" data-id="{{ $loop->iteration }}"><i class="fa fa-check"></i></button>
                                <form id="success{{$loop->iteration}}" action="{{ route('admin.store.payment-items.success', [$row->payment_id]) }}" method="POST" style="display: none;">
                                  @csrf
                                  @method('PATCH')
                                </form>
                                <button class="btn btn-danger delete" data-id="{{$loop->iteration}}"><i class="fa fa-trash"></i></button>
                                <form action="{{ route('admin.store.payment-items.delete', [$row->payment_id]) }}" method="POST" id="delete{{$loop->iteration}}" style="display: none;">
                                  @csrf
                                  @method('PATCH')
                                </form>
                              </div>
                            </td>
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

    {{-- Modal --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Make Payment</h4>
          </div>
          <div class="modal-body">

            <form action="{{ route('admin.make.payment') }}" method="POST" id="div-container">

                @csrf
  
                <div class="mb-3 row">
                    <label for="payment_type" class="col-sm-4 col-form-label">Payment Type</label>
                    <div class="col-sm-8">
                        <select name="payment_type" data-placeholder="-- List Bank --" id="ProductDiscount" class="chosen-select form-control @error('payment_type') is-invalid @enderror">
                            <option value="" selected disabled>-- List Bank --</option>
                            @foreach ($bank_list as $list)
                                <option value="{{ $list }}">{{ $list }}</option>
                            @endforeach
                        </select>
                        @error('payment_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="aacount_name" class="col-sm-4 col-form-label @error('account_name') is-invalid @enderror">Account Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="aacount_name" name="account_name">
                        @error('account_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label for="aacount_number" class="col-sm-4 col-form-label @error('account_number') is-invalid @enderror">Account Number</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="aacount_number" name="account_number">
                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                  
              </form>

          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            <button onclick="event.preventDefault(); document.getElementById('div-container').submit();" class="btn btn-primary" type="button">Create</button>
          </div>
        </div>
      </div>
    </div>

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