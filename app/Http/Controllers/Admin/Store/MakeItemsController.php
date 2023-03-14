<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Category;
use App\Models\Admin\Category_View;
use App\Models\Admin\Item;
use App\Models\Admin\Item_View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MakeItemsController extends Controller
{
    public function index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();
        $category = Category::all();

        return view('admin.store.make_items', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|regex:/^[\p{L}\s-]+$/u|max:255',
            'product_type' => 'required|string|max:255',
            'product_quantity' => 'required|string|max:255',
            'product_price' => 'required|string|max:255',
            'product_image' => 'required',
            'product_category' => 'required',
        ]);

        $price = str_replace('Rp. ', '', $request->product_price);

        $product_price = str_replace('.', '', $price);

        $items = Item::orderBy('id', 'DESC')->first();

        if ($items == Null) {
            $p_id = 'PNM0001';
        } else {
            $numRow = $items->id + 1;

            if ($numRow < 10) {
                $p_id = 'PNM' . '000' . $numRow;
            } elseif ($numRow >= 10 && $numRow <= 99) {
                $p_id = 'PNM' . '00' . $numRow;
            } elseif ($numRow >= 100 && $numRow <= 999) {
                $p_id = 'PNM' . '0' . $numRow;
            } elseif ($numRow >= 1000 && $numRow <= 9999) {
                $p_id = 'PNM' . $numRow;
            }
        }

        $imageArray = [];

        if ($request->hasFile('product_image')) {
            foreach ($request->product_image as $file) {
                $fileName = $p_id . '_' . date('d-m-Y') . '_' . uniqid() . '.' . $file->extension();

                $file->move(public_path('image_item'), $fileName);

                array_push($imageArray, $fileName);
            }
        }

        $fileImage = implode(', ', $imageArray);

        $category = implode(', ', $request->product_category);

        $sumX = explode(', ', $category);

        $ctgAll = 0;

        foreach ($sumX as $row) {
            $total = Category::where('product_category', $sumX[$ctgAll])
                ->first();

            $plus = $total->total + 1;

            Category::where('product_category', $sumX[$ctgAll])
                ->Update([
                    'total' => $plus
                ]);

            $ctgAll++;
        }

        if ($request->product_discount == Null) {
            $discount = 0;
        } else {
            $discount = $request->product_discount;
        }

        Item::create([
            'product_id' => $p_id,
            'product_name' => $request->product_name,
            'product_image' => $fileImage,
            'product_type' => $request->product_type,
            'product_quantity' => $request->product_quantity,
            'product_description' => $request->product_description,
            'product_detail' => $request->product_detail,
            'product_price' => $product_price,
            'product_discount' => $discount,
            'product_category' => $category,
            'product_rating' => 0,
            'product_review' => 0,
        ]);

        Item_View::create([
            'product_id' => $p_id,
            'product_name' => $request->product_name,
            'product_category' => $category,
            'product_price' => $product_price,
            'product_discount' => $discount,
            'product_rating' => 0,
            'product_view' => 0,
        ]);

        foreach ($sumX as $ctg) {
            Category_View::create([
                'product_id' => $p_id,
                'product_name' => $request->product_name,
                'product_category' => $ctg,
                'product_price' => $request->product_price,
                'product_view' => 0,
            ]);
        }

        return redirect()->back()->with('message_success', 'Success Post!');
    }
}
