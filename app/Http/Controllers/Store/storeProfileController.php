<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\User;
use App\Models\User\User_Address;
use App\Models\User\User_Cart;
use App\Models\User\User_Checkout;
use App\Models\User\User_Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class storeProfileController extends Controller
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

        $user_checkout = User_Checkout::where('user_id', $user->user_id)
            ->get();

        $address = User_Address::where('user_id', $user->user_id)
            ->get();

        $profile = User_Profile::where('user_id', $user->user_id)
            ->first();

        return view('store.profile', [
            'category' => $category,
            'user_cart' => $user_cart,
            'user_cart_count' => $user_cart_count,
            'user_checkout' => $user_checkout,
            'address' => $address,
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $user = User::where('email', Auth::user()->email)
            ->first();
        $check = User_Profile::where('user_id', $user->user_id)
            ->first();

        if ($request->name == $check->name && $request->bio == $check->bio && $request->gender == $check->gender && $request->date == $check->date_of_birth && $request->phone_number == $check->phone_number && $request->avatar == '') {
            return redirect()->back()->with('alert', 'No data has been changed.');
        }

        $request->validate([
            'avatar' => 'file|mimes:png,jpg,jpeg',
        ]);

        // File Avatar
        if ($request->avatar == "") {
            $fileAvatar = $check->avatar;
        } elseif ($check->avatar == NULL) {
            $fileAvatar = "AVATAR" . "_" . uniqid() . "." . $request->avatar->extension();
        } else {
            $fileAvatar = $check->avatar;
        }

        // Simpan File Avatar
        if ($fileAvatar != NULL) {
            if ($check->avatar == NULL) {
                $request->avatar->move(public_path('avatar'), $fileAvatar);
                $LocationFileAvatar = 'avatar/' . $fileAvatar;
            } else {
                $LocationFileAvatar = $check->avatar;
            }
        } else {
            $LocationFileAvatar = Null;
        }


        User::where('user_id', $user->user_id)
            ->update([
                'name' => $request->name,
            ]);

        User_Profile::where('user_id', $user->user_id)
            ->update([
                'name' => $request->name,
                'bio' => $request->bio,
                'gender' => $request->gender,
                'date_of_birth' => $request->date,
                'phone_number' => $request->phone_number,
                'avatar' => $LocationFileAvatar,
            ]);

        return redirect()->back()->with('alert', 'Data has been changed.');
    }
}
