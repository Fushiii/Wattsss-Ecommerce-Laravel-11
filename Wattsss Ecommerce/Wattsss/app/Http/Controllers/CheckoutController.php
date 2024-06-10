<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Process the checkout form and create the order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        return view('checkout', compact('cartItems'));
    }

    public function process(Request $request)
    {
        // Validate the checkout form fields
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        // Retrieve cart items for the current user
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // Create a new order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => 0,
            'status' => 'pending',
            'address' => $request->input('address'),
            'payment_method' => $request->input('payment_method')
        ]);

        // Add order items to the order
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->name,
                'image' => $cartItem->image,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]);
        }

        // Calculate the total amount for the order
        $order->calculateTotal();

        // Clear the user's cart
        Cart::where('user_id', Auth::id())->delete();
    }
    /**
     * Display the thank you page after checkout.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function thankyou(Order $order)
    {
        // Pass the order to the thankyou view
        return view('thankyou', ['order' => $order]);
    }
}
