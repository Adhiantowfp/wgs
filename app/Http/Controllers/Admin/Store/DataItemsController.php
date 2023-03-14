<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Category;
use App\Models\Admin\Category_View;
use App\Models\Admin\Item;
use App\Models\Admin\Item_Review;
use App\Models\Admin\Item_View;
use App\Models\User\User_Checkout;
use Illuminate\Http\Request;

class DataItemsController extends Controller
{
    public function index()
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();
        $item = Item::paginate(12);
        $total_item = Item::all()
            ->count();
        $total_shipping = User_Checkout::where('status', 'Shipping')
            ->count();
        $total_order = User_Checkout::count();
        $total_purchased = User_Checkout::where('status', 'Paid')
            ->count();

        return view('admin.store.data_items', [
            'data' => $data,
            'item' => $item,
            'total_item' => $total_item,
            'total_shipping' => $total_shipping,
            'total_order' => $total_order,
            'total_purchased' => $total_purchased,
        ]);
    }

    public function update($id)
    {
        $data = Admin::where('email', session('admin_email'))
            ->first();
        $item = Item::where('product_id', $id)
            ->first();
        $category = Category::all();

        return view('admin.store.edit_data', [
            'id' => $id,
            'data' => $data,
            'item' => $item,
            'category' => $category,
        ]);
    }

    public function updateItem(Request $request)
    {
        $check = Item::where('product_id', $request->id)
            ->first();

        $price = str_replace('Rp. ', '', $request->product_price);

        $product_price = str_replace('.', '', $price);

        if ($request->product_name == $check->product_name && $request->product_type == $check->product_type && $request->product_quantity == $check->product_quantity && $request->product_description == $check->product_description && $request->product_detail == $check->product_detail && $product_price == $check->product_price && $request->product_discount == $check->product_discount && implode(', ', $request->product_category) == $check->product_category && $request->product_image == '') {
            return redirect()->back()->with('message_fail', 'No data has been changed.');
        }


        $request->validate([
            'product_image' => 'file',
        ]);

        $imageArray = [];

        // File Image
        if ($request->product_image != NULL) {
            if ($request->hasFile('product_image')) {
                foreach ($request->product_image as $file) {
                    $fileName = $request->id . '_' . date('d-m-Y') . '_' . uniqid() . '.' . $file->extension();

                    $file->move(public_path('image_item'), $fileName);

                    array_push($imageArray, $fileName);
                }
            }
        }

        // Simpan File Image
        if ($request->product_image != NULL) {
            $fileImage = implode(', ', $imageArray);
        } else {
            $fileImage = $check->product_image;
        }

        $category = implode(', ', $request->product_category);

        $sumX = explode(', ', $category);

        foreach (explode(', ', $check->product_category) as $row) {
            $total1 = Category::where('product_category', $row)
                ->first();

            $plus1 = $total1->total - 1;

            Category::where('product_category', $row)
                ->Update([
                    'total' => $plus1
                ]);
        }

        foreach ($sumX as $row) {
            $total = Category::where('product_category', $row)
                ->first();

            $plus = $total->total + 1;

            Category::where('product_category', $row)
                ->Update([
                    'total' => $plus
                ]);
        }

        if ($request->product_discount == Null) {
            $discount = 0;
        } else {
            $discount = $request->product_discount;
        }

        Item::where('product_id', $request->id)
            ->update(
                [
                    'product_id' => $request->id,
                    'product_name' => $request->product_name,
                    'product_image' => $fileImage,
                    'product_type' => $request->product_type,
                    'product_quantity' => $request->product_quantity,
                    'product_description' => $request->product_description,
                    'product_detail' => $request->product_detail,
                    'product_price' => $product_price,
                    'product_discount' => $discount,
                    'product_category' => $category,
                    'product_rating' => $check->product_rating,
                    'product_review' => $check->product_review,
                ]
            );

        $item_review = Item_View::where('product_id', $request->id)
            ->first();
        Item_View::where('product_id', $request->id)
            ->update(
                [
                    'product_id' => $request->id,
                    'product_name' => $request->product_name,
                    'product_category' => $category,
                    'product_price' => $product_price,
                    'product_discount' => $discount,
                    'product_rating' => $item_review->product_rating,
                    'product_view' => $item_review->product_view,
                ]
            );

        foreach ($sumX as $ctg) {
            $category_view = Category_View::where('product_id', $request->id)
                ->first();
            Category_View::where('product_id', $request->id)
                ->update(
                    [
                        'product_id' => $request->id,
                        'product_name' => $request->product_name,
                        'product_category' => $ctg,
                        'product_price' => $request->product_price,
                        'product_view' => $category_view->product_view,
                    ]
                );
        }

        return redirect()->back()->with('message_success', 'Success update item!');
    }

    public function deleteItem($id)
    {
        $item = Item::where('product_id', $id)
            ->first();

        $item->delete();
        return redirect()->back()->with('message_success', 'Success delete item!');
    }
}
