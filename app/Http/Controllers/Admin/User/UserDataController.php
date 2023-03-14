<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\User\User_Profile;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();
        $user = User_Profile::paginate(12);

        return view('admin.user.user_data', [
            'data' => $data,
            'user' => $user,
        ]);
    }
}
