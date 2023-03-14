<?php

namespace App\Http\Controllers\Store\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\User_Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class storeAuthController extends Controller
{
    public function login(Request $request)
    {
        try
        {
            $user = User::where('username', $request->username)->orWhere('email', $request->username)->firstOrFail();

            if ($user) {
                if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                    return redirect()->back();
                }
            }
        }
        catch(ModelNotFoundException $e)
        {
            return redirect()->back()->with('message_fail', 'Wrong Username/Email or Password');
        }

    }
    
    public function register(Request $request)
    {
        $request->validate([
            'r_name' => 'required|string|regex:/^[\p{L}\s-]+$/u|max:255',
            'r_username' => 'required|string|unique:users,username',
            'r_email' => 'required|string|email|unique:users,username',
            'r_password' => 'required|string|min:8|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);

        $user = User::orderBy('id', 'DESC')->first();

        if ($user == Null) {
            $user_id = 'UMG0001';
        } else {
            $numRow = $user->id + 1;

            if ( $numRow < 10 ) {
                $user_id = 'UMG' . '000' . $numRow;
            } elseif ( $numRow >= 10 && $numRow <= 99 ) {
                $user_id = 'UMG' . '00' . $numRow;
            } elseif ( $numRow >= 100 && $numRow <= 999 ) {
                $user_id = 'UMG' . '0' . $numRow;
            } elseif ( $numRow >= 1000 && $numRow <= 9999 ) {
                $user_id = 'UMG' . $numRow;
            }
        }        

        User::create([
            'user_id' => $user_id,
            'name' => $request->r_name,
            'role' => 'User',
            'username' => $request->r_username,
            'email' => $request->r_email,
            'password' => Hash::make($request->r_password),
            'api_token' => Str::random(60),
        ]);

        User_Profile::create([
            'user_id' => $user_id,
            'name' => $request->r_name,
        ]);

        $user = User::where('username', $request->r_username)->orWhere('email', $request->r_username)->first();

        if (Auth::attempt(['email' => $user->email, 'password' => $request->r_password])) {
            return redirect()->back();
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->back();
    }
}
