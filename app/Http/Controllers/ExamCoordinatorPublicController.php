<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\ExamCoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExamCoordinatorPublicController extends Controller
{
    public function create()
    {
        $centers = Center::all();
        return view('front.examcoordinator.register', compact('centers'));
    }

    // Store submitted data
    public function store(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:exam_coodinators,email',
            'phone' => 'required|string|max:20',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'zip' => 'required|string|max:10',
            'password' => 'required|min:6|confirmed',
        ]);

        ExamCoordinator::create([
            'center_id' => $request->center_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'zip' => $request->zip,
            'password' => Hash::make($request->password),
            'status' => false, // inactive until admin approves
        ]);

        return redirect()->route('examcoordinator.public.create')
                         ->with('success', 'Your application has been submitted successfully. The admin will review and activate your account soon.');
    }
}
