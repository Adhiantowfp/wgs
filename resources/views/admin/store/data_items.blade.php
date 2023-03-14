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
                    <a class="btn btn-default" href="{{ route('admin.store.make-items') }}" title="Bootstrap 3 themes generator"><i class="fa fa-pencil-square-o"></i> Make Items</a>
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
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="info-box blue-bg">
                <i class="fa fa-cubes"></i>
                <div class="count">{{ $total_item }}</div>
                <div class="title">Total Items</div>
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

          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  Items List
                </header>
                <div class="table-responsive">
                  <table class="table table-striped table-advance table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Product Image</th>
                        <th class="text-center">Product Type</th>
                        <th class="text-center">Product Quantity</th>
                        <th class="text-center">Product Description</th>
                        <th class="text-center">Product Detail</th>
                        <th class="text-center">Product Discount</th>
                        <th class="text-center">Product price</th>
                        <th class="text-center">Product Category</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($item as $row)
                        <tr>
                          <td>{{ $row->product_id }}</td>
                          <td>{{ $row->product_name }}</td>
                          <td>
                            @if ($row->product_image != Null)
                              <button id="image" class="btn btn-primary btn-sm" data-toggle="modal" data-image="{{ $row->product_image }}" href="#myModal" title="Bootstrap 3 themes generator">View</button>
                            @endif
                          </td>
                          <td>{{ $row->product_type }}</td>
                          <td>{{ $row->product_quantity }}</td>
                          <td>
                            <textarea readonly cols="10" rows="2">{{ $row->product_description }}</textarea>
                          </td>
                          <td>
                            <textarea readonly cols="10" rows="2">{{ $row->product_detail }}</textarea>
                          </td>
                          <td>{{ $row->product_discount }}%</td>
                          <td>Rp. {{ number_format($row->product_price) }}</td>
                          <td>
                            @foreach (explode(', ', $row->product_category) as $ctg)
                              <a href="">    
                                <span class="label label-primary">{{ $ctg }}</span>
                              </a>
                            @endforeach
                          </td>
                          <td>
                            <div class="btn-group">
                              <button class="btn btn-info" onclick="event.preventDefault(); document.getElementById('editItem{{$loop->iteration}}').submit();"><i class="fa fa-pencil-square-o"></i></button>
                              <form id="editItem{{$loop->iteration}}" action="{{ route('admin.store.data-items.update', [$row->product_id]) }}" method="GET" style="display: none;">
                              </form>
                              <button class="btn btn-danger delete" data-id="{{$loop->iteration}}"><i class="fa fa-trash"></i></button>
                              <form action="{{ route('admin.store.data-items.delete-item', [$row->product_id]) }}" method="POST" id="delete{{$loop->iteration}}">
                                @csrf
                                @method('PATCH')
                              </form>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  
                  <div class="justify-content-center">
                    {{ $item->links('pagination::bootstrap-4') }}
                  </div>
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
            <h4 class="modal-title">View Image</h4>
          </div>
          <div class="modal-body">

            <div id="div-container" class="content-center" style="height: 450px; overflow-x: auto;">
                
            </div>

          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('js')
    
    <script>
      $(document).on('click', '#image', function () {
        const imageTag = document.querySelectorAll('.ImageTag');

        if (imageTag) {
          imageTag.forEach(el => el.remove());
        }

        var imageUrl = $(this).data('image')
        var imageArray = imageUrl.split(', ')

        imageArray.forEach(AddNew);

        
        function AddNew(item, index) {
          const DivContainer = document.getElementById('div-container');
          const newDiv1 = document.createElement('img');

          newDiv1.setAttribute('class', 'mr-1 mb-1 ImageTag');
          newDiv1.setAttribute('src', '/image_item/' + item);
          newDiv1.setAttribute('style', 'width: 250px; height: 250px;');

          DivContainer.appendChild(newDiv1);
        }
        // console.log(imageUrl.split(', '))
      })

      $(".delete").click(function () {
            var id = $(this).data('id')
            swal({
                title: "Are you sure?",
                text: "This delete has permanent!!",
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

    </script>

@endsection