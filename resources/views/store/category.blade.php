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
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li><a href="#">Category</a></li>
							<li><a href="#">{{ $value }}</a></li>
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

					<!-- STORE -->
					<div id="store" class="col-md-12">

						<!-- store products -->
						<div class="row">
                            @foreach ($item as $row)    
                                <!-- product -->
                                <div class="col-md-4 col-xs-6">
                                    <!-- product -->
                                    <div class="product">
                                        <div class="product-img">
                                            @php
                                                $imageArray = explode(', ', $row->product_image)
                                            @endphp
                                            <img src="{{ asset('image_item/' . $imageArray[0]) }}" style="height: 250px;" alt="">
                                            <div class="product-label">
                                                <span class="sale">-{{ $row->product_discount }}%</span>
                                                <span class="new">NEW</span>
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
                                </div>
                                <!-- /product -->
                            @endforeach
						</div>
						<!-- /store products -->
                        

						<!-- store bottom filter -->
						<div class="store-filter clearfix">
							<span class="store-qty">Showing 20-100 products</span>
							<ul class="store-pagination">
								{{ $item->links() }}
							</ul>
						</div>
						<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
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