<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Item;
use App\Models\Admin\Item_Review;
use App\Models\Admin\Item_View;
use App\Models\User;
use App\Models\User\User_Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeProductController extends Controller
{
    public function productView($p_name)
    {
        $category = Category::paginate(5);
        $item = Item::where('product_name', $p_name)
            ->first();
        $relate_product = Item::where('product_category', $item->product_category)
            ->where('product_id', '!=', $item->product_id)
            ->paginate(12);
        $item_review = Item_Review::where('product_id', $item->product_id)
            ->paginate(3);
        
        if ( Auth::check() ) {
            $user = User::where('name', Auth::user()->name)
                ->first();
            $user_cart = User_Cart::where('user_id', $user->user_id)
                ->get();
            $user_cart_count = User_Cart::where('user_id', Auth::user()->user_id)
                ->count();
        } else {
            $user_cart = '';
            $user_cart_count = '';
        }

        return view('store.product', [
            'category' => $category,
            'item' => $item,
            'relate_product' => $relate_product,
            'item_review' => $item_review,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count,
        ]);
    }
}
