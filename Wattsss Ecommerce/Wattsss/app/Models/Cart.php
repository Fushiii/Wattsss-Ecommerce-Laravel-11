<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity', 'image', 'name', 'price'];

    protected $appends = ['total_price']; // Appended attribute

    // Validation rules
    public static $rules = [
        'user_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
        // Add more validation rules as per your requirements
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for total price attribute
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Scope to retrieve cart items for a specific user
    public static function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Example method to calculate total price of all cart items for a user
    public static function calculateTotalPriceForUser($userId)
    {
        return self::byUser($userId)->sum('quantity * price');
    }

    public static function removeFromCart($cartItemId)
    {
        // Retrieve the cart item with the provided ID
        $cartItem = self::find($cartItemId);

        // Ensure the cart item exists and belongs to the authenticated user
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            // Delete the cart item
            return $cartItem->delete();
        }

        return false; // Return false if the cart item doesn't exist or user is not authorized
    }

}
