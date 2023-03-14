<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Category_View;
use App\Models\Admin\Item;
use App\Models\Admin\Item_View;
use App\Models\User;
use App\Models\User\User_Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeIndexController extends Controller
{
    public function Index()
    {
        $category = Category::paginate(5);
        $new_product = Item::orderBy('id', 'DESC')->paginate(12);
        $top_selling_product = Item_View::paginate(8);
        $top_selling_category = Category_View::paginate(4);

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

        return view('store.index', [
            'category' => $category,
            'new_product' => $new_product,
            'top_selling_product' => $top_selling_product,
            'top_selling_category' => $top_selling_category,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count,
        ]);
    }
}
