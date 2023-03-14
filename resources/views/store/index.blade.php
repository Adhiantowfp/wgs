@extends('layout.themplate')

@section('title', 'Warung Kopi Gowes')

@section('content')
	
												<div class="top-image">
													<img src="../asset/img/Scene-20.jpg" width="100%" height="800px" alt="error">
													<div class="text-top-image text-center">
													</div>
												</div>
										

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New Products</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										@foreach ($new_product as $row)	
											<!-- product -->
											<div class="product">
												<div class="product-img">
													@php
														$imageArray = explode(', ', $row->product_image)
													@endphp
													<img src="{{ asset('image_item/' . $imageArray[0]) }}" style="height: 250px;" alt="">
													<div class="product-label">
														{{-- <span class="sale">-{{ $row->product_discount }}%</span>
														<span class="new">NEW</span> --}}
													</div>
												</div>
												<div class="product-body">
													<p class="product-category">
														@foreach ( explode(', ', $row->product_category) as $ctg)
															{{ $ctg }}
														@endforeach
													</p>
													<h3 class="product-name"><a href="#">{{ $row->product_name }}</a></h3>
													@php
														if ($row->product_discount != 0) {
															$price = $row->product_price;
															$discount = $row->product_discount;
															$sum_discount = (($discount * 1) / 100) * $price;
															$newPrice = $price - $sum_discount;
														} else {
															$newPrice = $row->product_price;
														}
													@endphp
													<h4 class="product-price">Rp. {{ number_format($newPrice) }} <del class="product-old-price">Rp. {{ number_format($row->product_price) }}</del></h4>
													<div class="product-rating">
														@php
															if ($row->product_rating != 0 && $row->product_review != 0) {
																$rating = $row->product_rating / $row->product_review;
															} else {
																$rating = 0;
															}
														@endphp

														@if ( $rating == 0 )
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 1 && $rating < 2)
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>	
														@elseif( $rating >= 2 && $rating < 3)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 3 && $rating < 4)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 4 && $rating < 5)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>	
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 5)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														@endif
													</div>
													<div class="product-btns">
														<button onclick="location.href='{{ route('store.product.view', [$row->product_name]) }}'" class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
													</div>
												</div>
												<div class="add-to-cart">
													<form id="add-cart{{ $loop->iteration }}" action="{{ route('store.add.cart') }}" method="POST">
														@csrf
														@method('PATCH')
														<input type="text" name="product_id" id="product_id" value="{{ $row->product_id }}" style="display: none;">
														<button class="add-to-cart-btn" type="submit" onclick="event.preventDefault(); document.getElementById('add-cart{{ $loop->iteration }}').submit();"><i class="fa fa-shopping-cart"></i> add to cart</button>
													</form>
												</div>
											</div>
											<!-- /product -->
										@endforeach
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

	

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Sale</h3>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										@foreach ($top_selling_product as $row)	
											<!-- product -->
											<div class="product">
												<div class="product-img">
													@php
														$image = collect(DB::select("select * from items where product_id = '". $row->product_id . "'"))->first();
														
														$imageArray = explode(', ', $image->product_image);
													@endphp
													<img src="{{ asset('image_item/' . $imageArray[0]) }}" style="height: 250px;" alt="">
													<div class="product-label">
														<span class="sale">-{{ $row->product_discount }}%</span>
														@if ( $row->created_at->format('d') < $row->created_at->format('d') + 5 )
															<span class="new">NEW</span>
														@endif
													</div>
												</div>
												<div class="product-body">
													<p class="product-category">
														@foreach ( explode(', ', $row->product_category) as $ctg)
															{{ $ctg }}
														@endforeach
													</p>
													<h3 class="product-name"><a href="#">{{ $row->product_name }}</a></h3>
													@php
														if ($row->product_discount != 0) {
															$price = $row->product_price;
															$discount = $row->product_discount;
															$sum_discount = (($discount * 1) / 100) * $price;
															$newPrice = $price - $sum_discount;
														} else {
															$newPrice = $row->product_price;
														}
													@endphp
													<h4 class="product-price">Rp. {{ number_format($newPrice) }} <del class="product-old-price">Rp. {{ number_format($row->product_price) }}</del></h4>
													<div class="product-rating">
														@php
															if ($row->product_rating != 0 && $row->product_review != 0) {
																$rating = $row->product_rating / $row->product_review;
															} else {
																$rating = 0;
															}
														@endphp

														@if ( $rating == 0 )
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 1 && $rating < 2)
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>	
														@elseif( $rating >= 2 && $rating < 3)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 3 && $rating < 4)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 4 && $rating < 5)
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>	
															<i class="fa fa-star-o"></i>
														@elseif( $rating >= 5)	
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														@endif
													</div>
													<div class="product-btns">
														<button onclick="location.href='{{ route('store.product.view', [$row->product_name]) }}'" class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
													</div>
												</div>
												<div class="add-to-cart">
													<form id="add-cart{{ $loop->iteration }}" action="{{ route('store.add.cart') }}" method="POST">
														@csrf
														@method('PATCH')
														<input type="text" name="product_id" id="product_id" value="{{ $row->product_id }}" style="display: none;">
														<button class="add-to-cart-btn" type="submit" onclick="event.preventDefault(); document.getElementById('add-cart{{ $loop->iteration }}').submit();"><i class="fa fa-shopping-cart"></i> add to cart</button>
													</form>
												</div>
											</div>
											<!-- /product -->
										@endforeach
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
	
		<!-- /SECTION -->

@endsection

@section('js')
	
	<script>
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				item:1,
				loop:true,
				slideMargin:0,
				enableDrag: false,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}   
			});  
		});
	</script>

@endsection