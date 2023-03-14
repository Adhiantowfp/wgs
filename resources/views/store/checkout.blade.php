@extends('layout.themplate')

@section('title', 'Warung Kopi Gowes')

@section('content')

    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="breadcrumb-header">Checkout</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ route('store.index') }}">Home</a></li>
                        <li class="active">Checkout</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <form action="{{ route('store.product-checkout.submit') }}" method="POST">

                    @csrf

                    <div class="col-md-7">
                        <!-- Billing Details -->
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Billing address</h3>
                            </div>
                            <div class="form-group">
                                <a class="btn" data-toggle="modal" href="#ModalAddress"><i class="fa fa-plus"></i> Add New Address</a>
                            </div>
                            <div class="form-group">
                                <select class="input @error('shipping_address') is-invalid @enderror" name="shipping_address" id="">
                                    <option value="" selected disabled>-- Choose Address --</option>
                                    @foreach ($address as $row)
                                        <option value="{{ $row->address_id }}">Address {{ $loop->iteration }}</option>
                                    @endforeach
                                </select>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- /Billing Details -->

                        <!-- Shiping Details -->
                        <div class="shiping-details">
                            <div class="section-title">
                                <h3 class="title">Order Notes</h3>
                            </div>
                        </div>
                        <!-- /Shiping Details -->

                        <!-- Order notes -->
                        <div class="order-notes">
                            <textarea class="input" name="order_notes" placeholder="Order Notes"></textarea>
                        </div>
                        <!-- /Order notes -->
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-5 order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Your Order</h3>
                        </div>
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>PRODUCT</strong></div>
                                <div><strong>TOTAL</strong></div>
                            </div>
                            <div class="order-products">
                            @php
                                $total = [0];
                            @endphp
                            @foreach ($user_cart as $row)  
                                @php
                                    $item = collect(DB::select("select * from items where product_id = '". $row->product_id . "'"))->first();
                                    if ($item->product_discount != 0) {
                                        $price = $item->product_price;
                                        $discount = $item->product_discount;
                                        $sum_discount = (($discount * 1) / 100) * $price;
                                        $newPrice = $price - $sum_discount;
                                    } else {
                                        $newPrice = $item->product_price;
                                    }
                                    $sum_price = $newPrice * $row->product_quantity;
                                    array_push($total, $sum_price);
                                @endphp 
                                <input type="text" name="product_id[]" value="{{ $row->product_id }}" style="display: none !important;"> 
                                <input type="text" name="product_name[]" value="{{ $row->product_name }}" style="display: none !important;"> 
                                <input type="text" name="product_quantity[]" value="{{ $row->product_quantity }}" style="display: none !important;"> 
                                <input type="text" name="product_price[]" value="{{ $newPrice }}" style="display: none !important;"> 
                                <div class="order-col">
                                    <div>{{ $row->product_quantity }}x {{ $row->product_row }}</div>
                                    <div>Rp. {{ number_format($sum_price) }}</div>
                                </div>
                            @endforeach
                            </div>
                            <div class="order-col">
                                <div>Shiping</div>
                                <div><strong>FREE</strong></div>
                            </div>
                            <div class="order-col">
                                <div><strong>TOTAL</strong></div>
                                <div><strong class="order-total">Rp. {{ number_format(array_sum($total)) }}</strong></div>
                            </div>
                            <input type="text" name="price_total" value="{{ array_sum($total) }}" style="display: none !important;"> 
                        </div>
                        <div class="payment-method">
                            @foreach ($bank_list as $list)    
                                <div class="input-radio">
                                    <input type="radio" name="payment" value="{{ $list->payment_type }}" id="payment-{{ $loop->iteration }}">
                                    
                                    <label for="payment-{{ $loop->iteration }}">
                                        <span></span>
                                        {{ $list->payment_type }}
                                    </label>
                                    <div class="caption">
                                        <p>{{ $list->account_name }}</p>
                                        <p>{{ $list->account_number }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <div class="input-checkbox">
                            <input type="checkbox" id="terms">
                            <label for="terms">
                                <span></span>
                                I've read and accept the <a href="#">terms & conditions</a>
                            </label>
                        </div> --}}
                        <button class="primary-btn order-submit">Place order</button>
                    </div>
                </form>
                    <!-- /Order Details -->
                    
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Modal Register -->
		<div class="modal fade" id="ModalAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Make Address</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
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
				<div class="modal-body justify-content-center">


					<form action="{{ route('store.add.address') }}" id="addressForm" class="col-md-12" method="POST">

						@csrf

						<div class="form-group">
							<label for="name" class="text-gray-900">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" id="name" name="name" value="{{ old('name') }}">
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="phone_number" class="text-gray-900">Phone Number</label>
							<input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Enter your phone number" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
							@error('phone_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="province" class="text-gray-900">Province</label>
							<input type="province" class="form-control @error('province') is-invalid @enderror" placeholder="Enter your province" id="province" name="province" value="{{ old('province') }}">
							@error('province')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="city" class="text-gray-900">City</label>
							<input type="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter your city" id="city" name="city" value="{{ old('city') }}">
							@error('city')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="districts" class="text-gray-900">Districts</label>
							<input type="districts" class="form-control @error('districts') is-invalid @enderror" placeholder="Enter your districts" id="districts" name="districts" value="{{ old('districts') }}">
							@error('districts')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="zip_code" class="text-gray-900">Zip Code</label>
							<input type="zip_code" class="form-control @error('zip_code') is-invalid @enderror" placeholder="Enter your zip code" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
							@error('zip_code')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="address" class="text-gray-900">Address</label>
							<input type="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter your address" id="address" name="address" value="{{ old('address') }}">
							@error('address')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('addressForm').submit();">Create</button>
				</div>
			</div>
			</div>
		</div>

@endsection

@section('js')
	
	<script>
		$(document).ready(function() {
		});
	</script>

@endsection