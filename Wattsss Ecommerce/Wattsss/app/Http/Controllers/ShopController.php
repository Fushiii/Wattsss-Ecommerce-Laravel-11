<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::all();
        $category_id = $request->input('category_id');
        $query = Product::query();

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $sort = $request->input('sort');
        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    break;
            }
        }

        $products = $query->get();

        return view('shop', compact('products', 'categories', 'category_id', 'sort'));
    }

    public function addToCart(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            [
                'image' => $product->image,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ]
        );

        if (!$cart->wasRecentlyCreated) {
            $cart->increment('quantity');
        }

        return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
    }
}
