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
                    <h3 class="page-header"><i class="fa fa-th-list"></i> User Data</h3>
                </div>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ route('admin.index') }}">Home</a></li>
                <li><i class="fa fa-th-list"></i>User Data</li>
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
                  User Data
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">User ID</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone Number</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $row)
                            @php
                                $user_data = collect(DB::select("select * from users where user_id = '". $row->user_id . "'"))->first();
                            @endphp
                            <tr style="text-align: center;">
                                <td>{{ $user_data->user_id }}</td>
                                <td>{{ $user_data->username }}</td>
                                <td>{{ $user_data->name }}</td>
                                <td>{{ $user_data->email }}</td>
                                <td>{{ $row->phone_number }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="justify-content-center">
                    {{ $user->links('pagination::bootstrap-4') }}
                  </div>
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