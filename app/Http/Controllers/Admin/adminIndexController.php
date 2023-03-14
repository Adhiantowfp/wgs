<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;

class adminIndexController extends Controller
{
    public function Index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();

        $total_user = User::count();
        $total_shipping = User_Checkout::where('status', 'Shipping')
            ->count();
        $total_order = User_Checkout::count();
        $total_purchased = User_Checkout::where('status', 'Paid')
            ->count();
        $user_checkout = User_Checkout::paginate(12);

        return view('admin.index', [
            'data' => $data,
            'total_user' => $total_user,
            'total_shipping' => $total_shipping,
            'total_order' => $total_order,
            'total_purchased' => $total_purchased,
            'user_checkout' => $user_checkout,
        ]);
    }
}
