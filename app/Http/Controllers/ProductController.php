<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        return view('backend.products.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Product::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'পণ্য সফলভাবে তৈরি হয়েছে!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $product = Product::findOrFail($id);
        $product->update(['name' => $request->name]);

        return redirect()->route('products.index')->with('success', 'পণ্য সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'পণ্য সফলভাবে ডিলিট হয়েছে!');
    }
}


