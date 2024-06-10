<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display the cart view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve cart items for the current user
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Calculate the total price of all items in the cart
        $totalPrice = $cartItems->sum(function($cartItem) {
            return $cartItem->price * $cartItem->quantity;
        });

        // Return the cart view with cart items and total price
        return view('cart', compact('cartItems', 'totalPrice'));
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1); // Default quantity is 1 if not provided

            // Find the product
            $product = Product::findOrFail($productId);

            // Find or create the cart item
            $cartItem = Cart::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);

            // Update the quantity
            $cartItem->quantity += $quantity;

            // Set other product details (if they are not already set)
            if (!$cartItem->image) {
                $cartItem->image = $product->image;
            }
            if (!$cartItem->name) {
                $cartItem->name = $product->name;
            }
            if (!$cartItem->price) {
                $cartItem->price = $product->price;
            }

            // Save the cart item
            $cartItem->save();

            return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error adding product to cart: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'An error occurred while adding the product to the cart.'], 500);
        }
    }

    /**
     * Update cart item quantity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCart(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'cartItems.*.id' => 'required|exists:carts,id,user_id,' . Auth::id(),
            'cartItems.*.quantity' => 'required|integer|min:1',
        ]);

        // Process each cart item update
        foreach ($request->cartItems as $cartItemData) {
            $cartItem = Cart::find($cartItemData['id']);
            if ($cartItem) {
                $cartItem->quantity = $cartItemData['quantity'];
                $cartItem->save();
            }
        }

        return redirect()->route('cart.view')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove an item from the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart($cartItemId)
    {
        $deleted = Cart::removeFromCart($cartItemId);

        if ($deleted) {
            return redirect()->route('cart.view')->with('success', 'Item removed from cart successfully.');
        } else {
            return redirect()->route('cart.view')->with('error', 'Failed to remove item from cart.');
        }
    }
}
