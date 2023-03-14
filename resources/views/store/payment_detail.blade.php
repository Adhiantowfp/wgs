@extends('layout.themplate')

@section('title', 'Warung Kopi Gowes')

@section('content')
    

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
                <!-- Order Details -->
                <div class="col-md-12 order-details">
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
                                $order_product = [];
                                $data = [];
                                foreach (explode(', ',$user_checkout->product_id) as $row) {
                                    $product_id = collect(DB::select("select * from items where product_id = '". $row . "'"))->first();
                                    array_push($order_product, $product_id);
                                }
                                $qty = explode(', ', $user_checkout->product_quantity);
                                $price = explode(', ', $user_checkout->product_price);
                                $i = 0;
                            @endphp
                            @foreach ($order_product as $item)
                                <div class="order-col">
                                    <div>{{ $qty[$i] }}x {{ $item->product_name }}</div>
                                    <div>Rp. {{ number_format($price[$i]) }}</div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div>
                        <div class="order-col">
                            <div><strong>TOTAL</strong></div>
                            <div><strong class="order-total">Rp. {{ number_format($user_checkout->price_total) }}</strong></div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1" checked>
                            <label for="payment-1">
                                <span></span>
                                {{ $user_checkout->payment_type }}
                            </label>
                            @php
                                $tf = collect(DB::select("select * from payment__types where payment_type = '". $user_checkout->payment_type . "'"))->first();
                            @endphp
                            <div class="caption">
                                <p>{{ $tf->account_name }}</p>
                                <p>{{ $tf->account_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Order Details -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

@endsection

@section('js')
	
	<script>
		$(document).ready(function() {
		});
	</script>

@endsection