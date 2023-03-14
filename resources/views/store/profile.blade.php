@extends('layout.themplate')

@section('title', 'Warung Kopi Gowes')

@section('content')
    

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Unpaid bills</h3>
							</div>
							<table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Payment ID</th>
                                        <th scope="col">Payment Type</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user_checkout as $row)    
                                        <tr>
                                            <th>{{ $row->payment_id }}</th>
                                            <th>{{ $row->payment_type }}</th>
                                            <th>Rp. {{ number_format($row->price_total) }}</th>
                                            <td>{{ $row->status }}</td>
                                            <td>
                                                @php
                                                    $tf = collect(DB::select("select * from payment__types where payment_type = '". $row->payment_type . "'"))->first();
                                                @endphp
                                                @if ($row->status == 'Pending' || $row->status == 'Paid')
                                                    <a href="{{ route('store.payment-detail', [$row->payment_id]) }}" class="btn btn-info"><i class="fa fa-info"></i></a>
                                                @else
                                                    <a data-toggle="modal" href="#ModalPayment" id="payment-check" data-payment_id="{{ $row->payment_id }}" data-payment_type="{{ $tf->payment_type }}" data-account_name="{{ $tf->account_name }}" data-account_number="{{ $tf->account_number }}" class="btn btn-success"><i class="fa fa-check"></i></a>
                                                    <a href="{{ route('store.payment-detail', [$row->payment_id]) }}" class="btn btn-info"><i class="fa fa-info"></i></a>
                                                    <button type="button" class="btn btn-danger paymentDelete" data-id="{{ $row->payment_id }}"><i class="fa fa-times"></i></button>
                                                    <form action="{{ route('store.payment-delete', [$row->payment_id]) }}" method="POST" id="{{ $row->payment_id }}">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
						</div>
						<!-- /Billing Details -->

						<!-- Shiping Details -->
						<div class="shiping-details">
							<div class="section-title">
								<h3 class="title">Billing address</h3>
							</div>
                            <div class="form-group">
                                <a class="btn" data-toggle="modal" href="#ModalAddress"><i class="fa fa-plus"></i> Add New Address</a>
                            </div>
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Address Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($address as $row)    
                                        <tr>
                                            <th>Address {{ $loop->iteration }}</th>
                                            <td>
                                                <a id="address-info" data-toggle="modal" data-name="{{ $row->name }}" data-phone_number="{{ $row->phone_number }}" data-province="{{ $row->province }}" data-city="{{ $row->city }}" data-districts="{{ $row->districts }}" data-zip_code="{{ $row->zip_code }}" data-address="{{ $row->address }}" href="#ModalDetailAddress" class="btn btn-info"><i class="fa fa-info"></i></a>
                                                <button type="button" class="btn btn-danger deleteAddress" data-id={{ $row->address_id }}><i class="fa fa-times"></i></button>
                                                <form action="{{ route('store.delete.address', [$row->address_id]) }}" method="POST" id="{{ $row->address_id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
						</div>
					</div>

					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Profile</h3>
						</div>
                        @if ($profile->avatar == NULL)
                            <img id="img-avatar" class="mb-3 mx-auto d-block" style="width: 100px !important; height: 100px !important; display: flex; margin: auto;" src="{{ url('https://ui-avatars.com/api/?name='. Auth::user()->name .'&color=7F9CF5&background=EBF4FF')}}">
                        @else
                            <img id="img-avatar" class="btn img-profile mb-3 mx-auto d-block custom-ava" style="width: 100px !important; height: 100px !important; display: flex; margin: auto;" src="{{ asset($profile->avatar)}}">
                        @endif
                        <textarea cols="30" rows="2" style="border: none !important; margin: auto !important; display: flex; text-align: center;" readonly>{{ $profile->bio }}</textarea>
                        <output>Name : {{ $profile->name }} </output>
                        <output>Gender : {{ $profile->gender }}</output>
                        <output>Birth : {{ date('d M Y' ,strtotime($profile->date_of_birth)) }}</output>
                        <output>Phone Number : {{ $profile->phone_number }}</output>
						<a data-toggle="modal" href="#ModalProfile" class="primary-btn order-submit">Edit Profile</a>
					</div>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

        <!-- Modal Payment -->
		<div class="modal fade" id="ModalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="width: 350px !important;" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Payment</h5>
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


					<form action="{{ route('store.payment-proof') }}" id="paymentForm" enctype="multipart/form-data" class="col-md-12" method="POST">

						@csrf
                            <div class="payment-method">
                                <div class="input-radio">
                                    <input type="text" name="payment_id" id="payment_id" style="display: none !important;">
                                    <input type="radio" name="payment" id="payment-1" checked>
                                    <label for="payment-1">
                                        <span></span>
                                        <p id="payment_type"></p>
                                    </label>
                                    <div class="caption">
                                        <p id="account_name"></p>
                                        <p id="account_number"></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="">Proof of Payment</label>
                                <input type="file" name="image_payment">
                            </div>
						
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button type="button" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('paymentForm').submit();">Submit</button>
				</div>
			</div>
			</div>
		</div>

        <!-- Modal Address -->
		<div class="modal fade" id="ModalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
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


					<form action="{{ route('store.profile.update') }}" id="profileForm" class="col-md-12" method="POST" enctype="multipart/form-data">

						@csrf
                        @method('PATCH')

						<div class="form-group">
							<label for="name" class="text-gray-900">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" id="name" name="name" value="{{ $profile->name }}">
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="bio" class="text-gray-900">Bio</label>
							<textarea class="form-control @error('bio') is-invalid @enderror" placeholder="Enter your bio" id="bio" name="bio">{{ $profile->bio }}</textarea>
							@error('bio')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="gender" class="text-gray-900">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" placeholder="Enter your gender" id="gender">
                                <option value="" selected disabled>-- Gender --</option>
                                @if ($profile->gender == 'Laki-Laki')
                                    <option value="Laki-Laki" selected>Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                @elseif ($profile->gender == 'Perempuan')
                                    <option value="Laki-Laki" >Laki-Laki</option>
                                    <option value="Perempuan" selected>Perempuan</option>
                                @else
                                    <option value="Laki-Laki" >Laki-Laki</option>
                                    <option value="Perempuan" >Perempuan</option>
                                @endif
                            </select>
							@error('gender')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="date" class="text-gray-900">Date of Birth</label>
							<input type="date" class="form-control @error('date') is-invalid @enderror" placeholder="Enter your date" id="date" name="date" value="{{ $profile->date_of_birth }}">
							@error('date')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="phone_number" class="text-gray-900">Phone Number</label>
							<input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Enter your phone_number" id="phone_number" name="phone_number" value="{{ $profile->phone_number }}">
							@error('phone_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        <div class="form-group">
							<label for="avatar" class="text-gray-900">Avatar</label>
							<input type="file" class="form-control @error('avatar') is-invalid @enderror" placeholder="Enter your avatar" id="avatar" name="avatar" value="">
							@error('avatar')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('profileForm').submit();">Submit</button>
				</div>
			</div>
			</div>
		</div>

        <!-- Modal Address -->
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

        <!-- Modal Detail Address -->
		<div class="modal fade" id="ModalDetailAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Detail Address</h5>
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


					<form action="{{ route('store.add.address') }}" id="detailAddressForm" class="col-md-12" method="POST">

						@csrf

						<div class="form-group">
							<label for="name" class="text-gray-900">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" id="info-name" name="name" value="{{ old('name') }}">
							@error('name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="phone_number" class="text-gray-900">Phone Number</label>
							<input type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Enter your phone number" id="info-phone_number" name="phone_number" value="{{ old('phone_number') }}">
							@error('phone_number')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="province" class="text-gray-900">Province</label>
							<input type="province" class="form-control @error('province') is-invalid @enderror" placeholder="Enter your province" id="info-province" name="province" value="{{ old('province') }}">
							@error('province')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="city" class="text-gray-900">City</label>
							<input type="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter your city" id="info-city" name="city" value="{{ old('city') }}">
							@error('city')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="districts" class="text-gray-900">Districts</label>
							<input type="districts" class="form-control @error('districts') is-invalid @enderror" placeholder="Enter your districts" id="info-districts" name="districts" value="{{ old('districts') }}">
							@error('districts')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="zip_code" class="text-gray-900">Zip Code</label>
							<input type="zip_code" class="form-control @error('zip_code') is-invalid @enderror" placeholder="Enter your zip code" id="info-zip_code" name="zip_code" value="{{ old('zip_code') }}">
							@error('zip_code')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="address" class="text-gray-900">Address</label>
							<input type="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter your address" id="info-address" name="address" value="{{ old('address') }}">
							@error('address')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</form>
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

		$(document).on('click', '#payment-check', function () {

            var id = $(this).data('payment_id')
            var type = $(this).data('payment_type')
            var name = $(this).data('account_name')
            var number = $(this).data('account_number')

            $('#payment_id').val(id);
            $('#payment-1').val(type);
            $('#payment_type').text(type);
            $('#account_name').text(name);
            $('#account_number').text(number);
        })

		$(document).on('click', '#address-info', function () {

            var name = $(this).data('name')
            var phone_number = $(this).data('phone_number')
            var province = $(this).data('province')
            var city = $(this).data('city')
            var districts = $(this).data('districts')
            var zip_code = $(this).data('zip_code')
            var address = $(this).data('address')

            $('#info-name').val(name);
            $('#info-phone_number').val(phone_number);
            $('#info-province').val(province);
            $('#info-city').val(city);
            $('#info-districts').val(districts);
            $('#info-zip_code').val(zip_code);
            $('#info-address').val(address);
        })   

        $(".deleteAddress").click(function () {
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
                    $("#" + id).submit();
                }
            });
        })

        $(".paymentDelete").click(function () {
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
                    $("#" + id).submit();
                }
            });
        })
	</script>

@endsection