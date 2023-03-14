<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\User_Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class storeAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'province' => 'required',
            'city' => 'required',
            'districts' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
        ]);

        $user = User::where('name', Auth::user()->name)
            ->first();

        $address = User_Address::orderBy('id', 'DESC')->first();

        if ($address == Null) {
            $address_id = 'ADR0001';
        } else {
            $numRow = $address->id + 1;

            if ($numRow < 10) {
                $address_id = 'ADR' . '000' . $numRow;
            } elseif ($numRow >= 10 && $numRow <= 99) {
                $address_id = 'ADR' . '00' . $numRow;
            } elseif ($numRow >= 100 && $numRow <= 999) {
                $address_id = 'ADR' . '0' . $numRow;
            } elseif ($numRow >= 1000 && $numRow <= 9999) {
                $address_id = 'ADR' . $numRow;
            }
        }

        User_Address::create([
            'address_id' => $address_id,
            'user_id' => $user->user_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'province' => $request->province,
            'city' => $request->city,
            'districts' => $request->districts,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('alert', 'Success Created an Address!');
    }

    public function destroy($id)
    {
        $address = User_Address::where('address_id', $id)
            ->first();

        $address->forceDelete();
        return redirect()->back()->with('alert', 'Success delete address!');
    }
}
