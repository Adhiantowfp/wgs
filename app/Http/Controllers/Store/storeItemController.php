<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Item;
use App\Models\User\User_cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeItemController extends Controller
{
    public function index()
    {
        $category = Category::paginate(5);
        $all_category = Category::get();
        $item = Item::paginate(12);

        if (Auth::check()) {
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

        return view('store.item', [
            'category' => $category,
            'all_category' => $all_category,
            'item' => $item,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count
        ]);
    }
}
