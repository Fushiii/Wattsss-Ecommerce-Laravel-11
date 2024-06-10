<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'reason' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Apply::create($data);

        return redirect()->route('applySeller')->with('success', 'Application submitted successfully.');
    }

    public function index()
    {
        $applications = Apply::with('user')->get();
        return view('applications', compact('applications'));
    }

    public function approve($id)
    {
        $application = Apply::find($id);

        if ($application) {
            $user = $application->user;
            $user->role = 'seller'; // Assuming 3 is the seller role
            $user->save();

            $application->delete(); // Remove the application after approval

            return redirect()->route('admin.applications')->with('success', 'Application approved.');
        }

        return redirect()->route('admin.applications')->with('error', 'Application not found.');
    }

    public function reject($id)
    {
        $application = Apply::find($id);

        if ($application) {
            $application->delete(); // Remove the application after rejection

            return redirect()->route('admin.applications')->with('success', 'Application rejected.');
        }

        return redirect()->route('admin.applications')->with('error', 'Application not found.');
    }
}