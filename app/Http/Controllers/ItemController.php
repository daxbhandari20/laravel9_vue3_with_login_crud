<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function item(Request $request)
    {
        dd('here');
        foreach ($request->all() as $item) {
            Item::create([
                'name' => $item['name'],
                'price' => $item['price']
            ]);
        }
        return response()->json('success');
    }
}