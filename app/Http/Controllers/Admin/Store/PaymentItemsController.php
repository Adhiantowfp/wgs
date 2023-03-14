<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Payment_Type;
use App\Models\User\Payment_Verify;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;

class PaymentItemsController extends Controller
{
    public function index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();

        $bank_list = [
            'ANZ Indonesia', 'Artha Graha', 'ATMBPLUS', 'BANK ACEH', 'Bank Banten', 'Bank DBS', 'Bank Jago', 'Bank Jateng', 'Bank of India Indonesia', 'BCA Digital',
            'BCA Syariah', 'BENGKULU', 'BJB', 'BJB SYARIAH', 'BNI', 'BNI SY', 'BNP', 'BOC INDONESIA', 'BPD BALI', 'BPD Kaltim Kaltara',
            'BPD Maluku Malut', 'BPD SulutGo', 'BPR Eka', 'BPR KS', 'BPR Supra', 'BRI', 'BRI AGRONIAGA', 'BSI', 'BSI (BRIS)', 'BTN',
            'BTPN', 'BTPN Syariah', 'Bumi Arta', 'Capital Indonesia', 'CCB Indonesia', 'Chinatrust', 'CIMB Niaga', 'Citibank', 'Commonwealth', 'DANAMON',
            'DKI', 'DOKU', 'GANESHA', 'Harda', 'HSBC', 'ICBC', 'Ina Perdana', 'Index', 'JAMBI', 'Jasa Jakarta',
            'Jatim', 'JTrust Bank', 'Kalbar', 'Kalteng', 'KB Bukopin', 'KEB Hana', 'LAMPUNG', 'Mandiri', 'Mandiri Taspen', 'MAS',
            'Maspion', 'Mayapada', 'Maybank (d.h. BII)', 'MAYORA', 'Mega', 'Mega Syariah', 'Mestika', 'MNC Bank', 'Muamalat', 'MUFG Bank Ltd',
            'Nagari', 'Neo Commerce', 'Nobu', 'NTB', 'NTT', 'OCBC NISP', 'OCBC NISP', 'Oke', 'PANIN', 'Panin Dub Syariah',
            'Papua', ' Paypro', 'Permata', 'Prima Master Bank', 'QNB Indonesia', 'Rabobank', 'Riau', 'Sahabat Sampoerna', 'SBI Indonesia', 'SeaBank',
            'SHINHAN', 'Sinarmas', 'Standard Chartered', 'Sulselbar', 'SULTENG', 'SULTRA', 'SumselBabel', 'Sumut', 'Syariah Bukopin', 'TCASH',
            'Telkom', 'UOB', 'Victoria', 'Victoria Syariah', 'Woori Saudara', 'XL Tunai'
        ];

        $payment_list = Payment_Type::paginate(10);
        $payment_verify = Payment_Verify::paginate(10);

        return view('admin.store.payment_items', [
            'data' => $data,
            'bank_list' => $bank_list,
            'payment_list' => $payment_list,
            'payment_verify' => $payment_verify,
        ]);
    }

    public function makePayment(Request $request)
    {
        $request->validate([
            'payment_type' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
        ]);

        Payment_Type::create([
            'payment_type' => $request->payment_type,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'total' => 0,
        ]);

        return redirect()->back()->with('message_success', 'Success Make Payment!');
    }

    public function success($id)
    {
        Payment_Verify::where('payment_id', $id)
            ->update([
                'status' => 'Paid'
            ]);
        User_Checkout::where('payment_id', $id)
            ->update([
                'status' => 'Paid'
            ]);

        return redirect()->back()->with('message_success', 'User Payment Success Paid!');
    }

    public function delete($id)
    {
        Payment_Verify::where('payment_id', $id)
            ->update([
                'status' => 'Cancel'
            ]);
        User_Checkout::where('payment_id', $id)
            ->update([
                'status' => 'Cancel'
            ]);

        $p_verify = Payment_Verify::where('payment_id', $id)
            ->first();
        $u_checkout = User_Checkout::where('payment_id', $id)
            ->first();

        $p_verify->delete();
        $u_checkout->delete();

        return redirect()->back()->with('message_success', 'Success delete User Payment!');
    }
}
