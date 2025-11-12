<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\ExamCoordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ExamCoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordinators = ExamCoordinator::with('center')->latest()->get();
        return view('admin.examcoordinator.index', compact('coordinators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centers = Center::all();
        return view('admin.examcoordinator.create', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:exam_coordinators',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'password' => 'required|min:6',
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
        ]);

        return redirect()->route('admin.examcoordinator.index')->with('success', 'Exam Coordinator created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coordinator = ExamCoordinator::findOrFail($id);
        $centers = Center::all();
        return view('admin.examcoordinator.edit', compact('coordinator', 'centers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coordinator = ExamCoordinator::findOrFail($id);

        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:exam_coordinators,email,' . $id,
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $coordinator->update($data);

        return redirect()->route('admin.examcoordinator.index')->with('success', 'Exam Coordinator updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coordinator = ExamCoordinator::findOrFail($id);
        $coordinator->delete();

        return redirect()->route('admin.examcoordinator.index')->with('success', 'Exam Coordinator deleted successfully.');
    }
}
