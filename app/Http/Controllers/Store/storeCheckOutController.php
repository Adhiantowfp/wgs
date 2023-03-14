<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Payment_Type;
use App\Models\User;
use App\Models\User\User_Address;
use App\Models\User\User_Cart;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeCheckOutController extends Controller
{
    public function index()
    {
        $category = Category::paginate(5);

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

        $bank_list = Payment_Type::get();

        $address = User_Address::where('user_id', $user->user_id)
            ->get();

        return view('store.checkout', [
            'category' => $category,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count,
            'bank_list' => $bank_list,
            'address' => $address,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required',
        ]);

        if ($request->payment == Null) {
            return redirect()->back()->with('alert', 'No payment select!');
        }

        if ($request->product_id == Null) {
            return redirect()->back()->with('alert', 'No items!');
        }

        $product_id = implode(', ', $request->product_id);
        $product_name = implode(', ', $request->product_name);
        $product_quantity = implode(', ', $request->product_quantity);
        $product_price = implode(', ', $request->product_price);

        $user = User::where('name', Auth::user()->name)
            ->first();

        $payment = User_Checkout::orderBy('id', 'DESC')->first();

        if ($payment == Null) {
            $payment_id = 'TF0001';
        } else {
            $numRow = $payment->id + 1;

            if ($numRow < 10) {
                $payment_id = 'TF' . '000' . $numRow;
            } elseif ($numRow >= 10 && $numRow <= 99) {
                $payment_id = 'TF' . '00' . $numRow;
            } elseif ($numRow >= 100 && $numRow <= 999) {
                $payment_id = 'TF' . '0' . $numRow;
            } elseif ($numRow >= 1000 && $numRow <= 9999) {
                $payment_id = 'TF' . $numRow;
            }
        }

        foreach ($request->product_id as $id) {
            $user_cart = User_Cart::where('product_id', $id)
                ->first();
            $user_cart->forceDelete();
        }

        User_Checkout::create([
            'payment_id' => $payment_id,
            'user_id' => $user->user_id,
            'address_id' => $request->shipping_address,
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_quantity' => $product_quantity,
            'product_price' => $product_price,
            'price_total' => $request->price_total,
            'order_notes' => $request->order_notes,
            'payment_type' => $request->payment,
            'status' => 'Unpaid',
        ]);

        return redirect()->route('store.profile');
    }
}
