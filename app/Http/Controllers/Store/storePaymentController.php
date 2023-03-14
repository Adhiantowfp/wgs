<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\User;
use App\Models\User\Payment_Verify;
use App\Models\User\User_Cart;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storePaymentController extends Controller
{
    public function paymentDetail($payment_id)
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

        $user_checkout = User_Checkout::where('payment_id', $payment_id)
            ->first();

        return view('store.payment_detail', [
            'category' => $category,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count,
            'user_checkout' => $user_checkout,
        ]);
    }

    public function paymentProof(Request $request)
    {
        $request->validate([
            'image_payment' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $user = User::where('name', Auth::user()->name)
            ->first();

        $payment = User_Checkout::where('payment_id', $request->payment_id)
            ->first();

        // File Upload
        // File 1
        $fileName1 = $payment->payment_id . "_" . uniqid() . "." . $request->image_payment->extension();

        // Save File 1
        $request->image_payment->move(public_path('payment'), $fileName1);


        Payment_Verify::create([
            'payment_id' => $payment->payment_id,
            'user_id' => $user->user_id,
            'price_total' => $payment->price_total,
            'image_payment' => 'payment/' . $fileName1,
            'payment_type' => $payment->payment_type,
            'status' => 'Pending',
        ]);

        User_Checkout::where('payment_id', $request->payment_id)
            ->update([
                'status' => 'Pending',
            ]);

        return redirect()->back()->with('alert', 'Success! File will be checked by admin soon!');
    }

    public function paymentDelete($payment_id)
    {
        $payment = User_Checkout::where('payment_id', $payment_id)
            ->first();

        $payment->forceDelete();

        return redirect()->back()->with('alert', 'Success delete payment!');
    }
}
