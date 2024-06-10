<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::all(); // Fetch all categories
        $products = Product::whereRaw('id % 2 = 0')->limit(9)->get();
        return view('dashboard', compact('user', 'categories', 'products'));
    }

    public function customerDashboard()
    {
        return $this->index();
    }

    public function sellerDashboard()
    {
        return $this->index();
    }

    public function adminDashboard()
    {
        return $this->index();
    }
}
