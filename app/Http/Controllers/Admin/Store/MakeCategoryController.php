<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class MakeCategoryController extends Controller
{
    public function store(Request $request)
    {
        // Save Category
        foreach ($request->product_category as $row) {
            if ($row != Null) {
                $category = Category::where('product_category', $row)
                    ->first();
    
                if ( $category == Null ) {
                    Category::create([
                        'product_category' => $row,
                        'total' => 0,
                    ]);
                }
            }
        }

        return redirect()->back()->with('message_success', 'Success Make Category!');
    }
}