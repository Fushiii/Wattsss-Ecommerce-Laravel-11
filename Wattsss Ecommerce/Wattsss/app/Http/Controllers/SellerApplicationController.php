<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apply;

class SellerApplicationController extends Controller
{
    public function showApplicationForm()
    {
        return view('applySeller');
    }

    public function applySeller(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'reason' => 'required',
        ]);

        $user = Auth::user();
        if ($user) {
            Apply::create([
                'user_id' => $user->id,
                'name' => $request->input('name'),
                'reason' => $request->input('reason'),
            ]);

            return redirect()->route('applySeller')->with('success', 'Application submitted successfully. Please wait for admin approval.');
        }

        return redirect()->route('login')->with('error', 'You need to log in first.');
    }
}
