<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class adminAuthController extends Controller
{
    public function login()
    {
        return view('admin.login.login');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $login = Admin::where('username', $request->username)
                ->firstOrfail();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message_fail', 'Incorrect Username or Password!');
        }

        if ($login) {
            if (Hash::check($request->password, $login->password)) {
                session(['admin_login' => true]);
                session(['admin_email' => $login->email]);

                return redirect(route('admin.index'));
            }
        }

        return redirect(route('admin.login'))->with('message_fail', 'Incorrect Username or Password!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect(route('admin.login'))->with('message_success', 'Success Logout!');
    }
}
