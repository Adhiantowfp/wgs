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
                    <h3 class="page-header"><i class="fa fa-th-list"></i> Make Items</h3>
                    <div>
                      <a a class="btn btn-success" data-toggle="modal" href="#myModal"><i class="fa fa-pencil-square-o"></i> Make Category</a>
                      <a class="btn btn-default" href="{{ route('admin.store.data-items') }}" title="Bootstrap 3 themes generator"><i class="fa fa-list"></i> Data Items</a>
                    </div>
                </div>
              <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ route('admin.index') }}">Home</a></li>
                <li><i class="fa fa-th-list"></i>Make Items</li>
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
            <form class="form-validate form-horizontal" enctype="multipart/form-data" id="feedback_form" method="POST" action="{{ route('admin.store.make-items.submit') }}">
            
            @csrf
                
            <div class="col-lg-6">
              <section class="panel">
                <div class="panel-body">
                  <div class="form">
                    
                      <div class="form-group ">
                        <label for="ProductName" class="control-label col-lg-3 text-left">Product Name <span class="required">*</span></label>
                        <div class="col-lg-9">
                            <input class="form-control @error('product_name') is-invalid @enderror" id="ProductName" value="{{ old('product_name') }}" name="product_name" type="text"/>
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group ">
                        <label for="ProductType" class="control-label col-lg-3 text-left">Product Type <span class="required">*</span></label>
                        <div class="col-lg-3">
                          <input class="form-control @error('product_type') is-invalid @enderror" id="ProductType" value="{{ old('product_type') }}" name="product_type" type="text"/>
                          @error('product_type')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <label for="ProductQty" class="control-label col-lg-3 text-left">Product Qty <span class="required">*</span></label>
                        <div class="col-lg-3">
                          <input class="form-control @error('product_quantity') is-invalid @enderror" id="ProductQty" value="{{ old('product_quantity') }}" name="product_quantity" type="number" />
                          @error('product_quantity')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group ">
                        <label for="ProductDesc" class="control-label col-lg-3 text-left">Product Desc </label>
                        <div class="col-lg-9">
                            <textarea class="form-control" id="ProductDesc" name="product_description">{{ old('product_description') }}</textarea>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label for="ProductDetail" class="control-label col-lg-3 text-left">Product Detail </label>
                        <div class="col-lg-9">
                            <textarea class="form-control" id="ProductDetail" name="product_detail">{{ old('product_detail') }}</textarea>
                        </div>
                      </div>
                      <div class="form-group ">
                        <label for="ProductPrice" class="control-label col-lg-3 text-left">Product Price <span class="required">*</span></label>
                        <div class="col-lg-9">
                            <input class="form-control @error('product_price') is-invalid @enderror" id="ProductPrice" value="{{ old('product_price') }}" name="product_price" type="text"/>
                            @error('product_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group ">
                        <label for="ProductDiscount" class="control-label col-lg-3 text-left">Product Discount <span class="required">*</span></label>
                        <div class="col-lg-9">
                            <select name="product_discount" data-placeholder="Discount" id="ProductDiscount" class="chosen-select form-control @error('product_discount') is-invalid @enderror">
                              <option value=""></option>
                              @for ($i = 0; $i <= 100; $i++)
                                @if ( old('product_discount') == $i )  
                                  <option value="{{ $i }}" selected>{{ $i }}%</option>
                                @else  
                                  <option value="{{ $i }}">{{ $i }}%</option>
                                @endif
                              @endfor
                            </select>
                            @error('product_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                </div>
  
                </div>
              </section>
            </div>
            <div class="col-lg-6">
              <section class="panel">
                <div class="panel-body">
                  <div class="form">
                    <div class="form-group ">
                      <label for="ProductCategory" class="control-label col-lg-3 text-left">Product Category <span class="required">*</span></label>
                      <div class="col-lg-9">
                          <select name="product_category[]" data-placeholder="-- Category --" id="ProductCategory" multiple class="chosen-select form-control @error('product_category') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($category->sortBy('product_category') as $row)
                                <option value="{{ $row->product_category }}" {{ in_array($row->product_category, old('product_category') ?: []) ? 'selected': ''}} >{{ $row->product_category }}</option>
                            @endforeach
                          </select>
                          @error('product_category')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                    </div>
                    <div class="form-group " >
                        <label for="ProductName" class="control-label col-lg-3 text-left">Product Image </label>
                        <div class="col-lg-9">
                            <input class="form-control @error('product_image') is-invalid @enderror" id="ProductName" value="{{ old('product_image') }}" name="product_image[]" type="file" multiple/>
                            @error('product_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group " >
                        <div class="col-lg-12">
                            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
  
                </div>
              </section>
            </div>
        </div>
    </form>
        </section>
    </section>
    <!--main content end-->

    {{-- Modal --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Make Category</h4>
          </div>
          <div class="modal-body">

            <form action="{{ route('admin.store.make-category.submit') }}" method="POST" id="div-container">

              @csrf

              <div class="mb-3 row">
                <label for="Category" class="col-sm-4 col-form-label">Category 1</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="Category" name="product_category[]">
                </div>
              </div>
                
            </form>

          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            <button class="btn btn-default btn-add" type="button" onclick="">+</button>
            <a class="btn btn-success" href="{{ route('admin.store.make-category.submit') }}" onclick="event.preventDefault(); document.getElementById('div-container').submit();">Create</a>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('js')
    
    <script>
      const BtnAdd = document.querySelector('.btn-add');
      const DivContainer = document.getElementById('div-container');

      BtnAdd.addEventListener('click', AddNew);

      var click = 1;

      function AddNew() {
        click += 1;

        const newDiv1 = document.createElement('div');
        const newDiv2 = document.createElement('label');
        const newDiv3 = document.createElement('div');
        const newDiv4 = document.createElement('input');
      
        newDiv1.setAttribute('class', 'mb-3 row');

        newDiv2.setAttribute('for', 'Category' + click);
        newDiv2.setAttribute('class', 'col-sm-4');
        newDiv2.innerHTML = 'Category ' + click;

        newDiv3.setAttribute('class', 'col-sm-8');

        newDiv4.setAttribute('type', 'text');
        newDiv4.setAttribute('class', 'form-control');
        newDiv4.setAttribute('id', 'Category' + click);
        newDiv4.setAttribute('name', 'product_category[]');

        DivContainer.appendChild(newDiv1);
        newDiv1.appendChild(newDiv2);
        newDiv1.appendChild(newDiv3);
        newDiv3.appendChild(newDiv4);
      }

      $(".chosen-select").chosen({
        no_results_text: 'Oops, Nothing found!'
      })

      var rupiah1 = document.getElementById('ProductPrice');
        rupiah1.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah1.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah1     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah1 += separator + ribuan.join('.');
            }

            rupiah1 = split[1] != undefined ? rupiah1 + ',' + split[1] : rupiah1;
            return prefix == undefined ? rupiah1 : (rupiah1 ? 'Rp. ' + rupiah1 : '');
        }
    </script>

@endsection