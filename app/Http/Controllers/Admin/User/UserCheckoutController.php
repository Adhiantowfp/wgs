<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;

class UserCheckoutController extends Controller
{
    public function index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();
        $user = User_Checkout::where('status', 'Paid')
            ->paginate(12);

        return view('admin.user.user_checkout', [
            'data' => $data,
            'user' => $user,
        ]);
    }
}
