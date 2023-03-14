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
                        <li><a href="#">All Categories</a></li>
                        @foreach (explode(', ', $item->product_category) as $ctg)
                            <li><a href="#">{{ ucwords(strtolower($ctg)) }}</a></li>
                        @endforeach
                        <li class="active">{{ ucwords(strtolower($item->product_name)) }}</li>
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
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        @foreach (explode(', ', $item->product_image) as $image)
                            <div class="product-preview">
                                <img src="{{ asset('image_item/' . $image) }}" alt="" style="height: 450px;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        @foreach (explode(', ', $item->product_image) as $image)
                            <div class="product-preview">
                                <img src="{{ asset('image_item/' . $image) }}" alt="" style="height: 150px;">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{ ucwords(strtolower($item->product_name)) }}</h2>
                        <div>
                            <div class="product-rating">
                                @php
                                    if ($item->product_rating != 0 && $item->product_review != 0) {
                                        $rating = $item->product_rating / $item->product_review;
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
                            <a class="review-link" href="#">{{ $item->product_review }} Review(s) | Add your review</a>
                        </div>
                        <div>
                            @php
                                if ($item->product_discount != 0) {
                                    $price = $item->product_price;
                                    $discount = $item->product_discount;
                                    $sum_discount = (($discount * 1) / 100) * $price;
                                    $newPrice = $price - $sum_discount;
                                } else {
                                    $newPrice = $item->product_price;
                                }
                            @endphp
                            <h3 class="product-price">Rp. {{ number_format($newPrice) }} <del class="product-old-price">Rp. {{ number_format($item->product_price) }}</del></h3>
                            @if ( $item->product_quantity == 0 )
                                <span class="product-available">Sold Out</span>
                            @else
                                <span class="product-available">In Stock</span>
                            @endif
                        </div>

                        @if ($item->product_description == Null)
                            <textarea readonly rows="10" cols="60" style="border: none;">{!! $item->product_description !!}</textarea>
                        @else
                            <textarea readonly rows="10" cols="60" style="border: none;">{!! $item->product_description !!}</textarea>
                        @endif

                        <form action="{{ route('store.add.cart-item') }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <input class="input-number" readonly name="product_id" type="text" style="display: none" value="{{ $item->product_id }}">
                            <div class="product-options">
                                <label>
                                    Type
                                    <input class="input-number" readonly type="text" value="{{ $item->product_type }}">
                                </label>
                            </div>
                            
                            <div class="add-to-cart">
                                <div class="qty-label">
                                Qty
                                {{-- <div class="input-number"> --}}
                                    <input type="number" class="input-number" min="0" max="{{ $item->product_quantity }}" value="0" id="ProductQuantity" name="product_quantity">
                                    {{-- <span class="qty-up">+</span> --}}
                                    {{-- <span class="qty-down">-</span> --}}
                                {{-- </div> --}}
                            </div>
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        </form>
                        </div>
                        
                        <ul class="product-links">
                            <li>Category:</li>
                            @foreach (explode(', ', $item->product_category) as $ctg)
                                <li><a href="#">{{ ucwords(strtolower($ctg)) }}</a></li>
                            @endforeach
                        </ul>

                       

                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                            <li><a data-toggle="tab" href="#tab2">Details</a></li>
                            <li><a data-toggle="tab" href="#tab3">Reviews ({{ $item->product_review }})</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea readonly rows="10" cols="60" style="border: none;">{!! $item->product_description !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab1  -->

                            <!-- tab2  -->
                            <div id="tab2" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea readonly rows="10" cols="60" style="border: none;">{!! $item->product_detail !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab2  -->

                            <!-- tab3  -->
                            <div id="tab3" class="tab-pane fade in">
                                <div class="row">
                                    <!-- Rating -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>{{ $item->product_rating }}</span>
                                                <div class="rating-stars">
                                                    @php
                                                        if ($item->product_rating != 0 && $item->product_review != 0) {
                                                            $rating = $item->product_rating / $item->product_review;
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
                                            </div>
                                            <ul class="rating">
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    @php
                                                        $rating5 = collect(DB::select("select * from item__reviews where product_id = '". $item->product_id . "'" . " and product_rating = '5'"))->count();
                                                        $rating4 = collect(DB::select("select * from item__reviews where product_id = '". $item->product_id . "'" . " and product_rating = '4'"))->count();
                                                        $rating3 = collect(DB::select("select * from item__reviews where product_id = '". $item->product_id . "'" . " and product_rating = '3'"))->count();
                                                        $rating2 = collect(DB::select("select * from item__reviews where product_id = '". $item->product_id . "'" . " and product_rating = '2'"))->count();
                                                        $rating1 = collect(DB::select("select * from item__reviews where product_id = '". $item->product_id . "'" . " and product_rating = '1'"))->count();
                                                        
                                                        $persen5 = 0;
                                                        $persen4 = 0;
                                                        $persen3 = 0;
                                                        $persen2 = 0;
                                                        $persen1 = 0;

                                                        if ($rating5 != 0 && $item->product_review != 0) {
                                                            $persen5 = ($rating5 * 100) / $item->product_review;
                                                        }
                                                        
                                                        if ($rating4 != 0 && $item->product_review != 0) {
                                                            $persen4 = ($rating4 * 100) / $item->product_review;
                                                        }
                                                        
                                                        if ($rating3 != 0 && $item->product_review != 0) {
                                                            $persen3 = ($rating3 * 100) / $item->product_review;
                                                        }
                                                        
                                                        if ($rating2 != 0 && $item->product_review != 0) {
                                                            $persen2 = ($rating2 * 100) / $item->product_review;
                                                        }
                                                        
                                                        if ($rating1 != 0 && $item->product_review != 0) {
                                                            $persen1 = ($rating1 * 100) / $item->product_review;
                                                        }

                                                    @endphp
                                                    <div class="rating-progress">
                                                        <div style="width: {{ $persen5 }}%;"></div>
                                                    </div>
                                                    <span class="sum">{{ $rating5 }}</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: {{ $persen4 }}0%;"></div>
                                                    </div>
                                                    <span class="sum">{{ $rating4 }}</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: {{ $persen3 }}0%;"></div>
                                                    </div>
                                                    <span class="sum">{{ $rating3 }}</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: {{ $persen2 }}0%;"></div>
                                                    </div>
                                                    <span class="sum">{{ $rating2 }}</span>
                                                </li>
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: {{ $persen1 }}0%;"></div>
                                                    </div>
                                                    <span class="sum">{{ $rating1 }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Rating -->

                                    <!-- Reviews -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            <ul class="reviews">
                                                @if ($item_review[0] == Null)
                                                    <li>Not Available</li>
                                                @else
                                                    @foreach ($item_review as $row)
                                                        <li>
                                                            <div class="review-heading">
                                                                <h5 class="name">{{ $row->name }}</h5>
                                                                <p class="date">{{ $row->created_at->format('d M Y, g:i A') }}</p>
                                                                <div class="review-rating">
                                                                    @if ( $row->product_rating == 0 )
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    @elseif( $row->product_rating >= 1 && $row->product_rating < 2)
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>	
                                                                    @elseif( $row->product_rating >= 2 && $row->product_rating < 3)	
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    @elseif( $row->product_rating >= 3 && $row->product_rating < 4)	
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    @elseif( $row->product_rating >= 4 && $row->product_rating < 5)
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>	
                                                                        <i class="fa fa-star-o"></i>
                                                                    @elseif( $row->product_rating >= 5)	
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="review-body">
                                                                <p>{{ $row->product_review }}</p>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                            <ul class="reviews-pagination">
                                                {{ $item_review->links('pagination::bootstrap-4') }}
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Reviews -->
                                </div>
                            </div>
                            <!-- /tab3  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                @if ($relate_product[0] != Null)
                    <div class="col-md-12">
                        <div class="section-title text-center">
                            <h3 class="title">Related Products</h3>
                        </div>
                    </div>

                    @foreach ($relate_product as $row)
                        <!-- product -->
                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-img">
                                    @php
                                        $image = collect(DB::select("select * from items where product_id = '". $row->product_id . "'"))->first();
                                        
                                        $imageArray = explode(', ', $image->product_image);
                                    @endphp
                                    <img src="{{ asset('image_item/' . $imageArray[0]) }}" style="height: 250px;" alt="">
                                    <div class="product-label">
                                        <span class="sale">-{{ $row->product_discount }}%</span>
                                        {{-- @if ( $row->created_at->format('d') < $row->created_at->format('d') + 5 )
                                            <span class="new">NEW</span>
                                        @endif --}}
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
                                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                        <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                        <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
                            </div>
                        </div>
                        <!-- /product -->
                    @endforeach
                @endif



            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->

@endsection

@section('js')
    
    <script type="text/javascript">
        
    </script>

@endsection