<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Item;
use App\Models\User;
use App\Models\User\User_Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeCartController extends Controller
{
    public function addCart(Request $request)
    {
        if (Auth::check()) {
            $user = User::where('name', Auth::user()->name)
                ->first();
            $product = Item::where('product_id', $request->product_id)
                ->first();

            $user_cart = User_Cart::where('user_id', $user->user_id)
                ->where('product_id', $product->product_id)
                ->first();

            if ($user_cart == Null) {
                User_Cart::create([
                    'user_id' => $user->user_id,
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'product_quantity' => 1,
                ]);
                $qty = $product->product_quantity - 1;
                Item::where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $qty
                    ]);
                return redirect()->back();
            } elseif ($product->product_quantity == 0) {
                return redirect()->back()->with('alert', "you've reached the limit");
            } else {
                $product_quantity = $user_cart->product_quantity + 1;
                User_Cart::where('user_id', $user->user_id)
                    ->where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $product_quantity,
                    ]);
                $qty = $product->product_quantity - 1;
                Item::where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $qty
                    ]);
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('alert', 'Login terlebih dahulu!');
        }
    }

    public function addCartItem(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'product_quantity' => 'required'
            ]);

            $user = User::where('name', Auth::user()->name)
                ->first();
            $product = Item::where('product_id', $request->product_id)
                ->first();

            $user_cart = User_Cart::where('user_id', $user->user_id)
                ->where('product_id', $product->product_id)
                ->first();

            if ($request->product_quantity > $product->product_quantity) {
                return redirect()->back()->with('alert', "you've reached the limit");
            }

            if ($user_cart == Null) {
                User_Cart::create([
                    'user_id' => $user->user_id,
                    'product_id' => $product->product_id,
                    'product_name' => $product->product_name,
                    'product_quantity' => $request->product_quantity,
                ]);
                $qty = $product->product_quantity - $request->product_quantity;
                Item::where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $qty
                    ]);
                return redirect()->back();
            } else {
                $product_quantity = $user_cart->product_quantity + $request->product_quantity;
                User_Cart::where('user_id', $user->user_id)
                    ->where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $product_quantity,
                    ]);
                $qty = $product->product_quantity - $request->product_quantity;
                Item::where('product_id', $request->product_id)
                    ->update([
                        'product_quantity' => $qty
                    ]);
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('alert', 'Login terlebih dahulu!');
        }
    }
}
