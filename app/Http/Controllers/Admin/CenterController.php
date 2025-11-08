<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centers = Center::all();
        return view('admin.center.index',compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.center.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'contact_person' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
            ]);
            
            Center::create($request->all());
            toastr()->success('Center Added Successfully');
            return redirect()->route('admin.center.index');
        }catch (\Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
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
        $center = Center::findOrFail($id);
        return view('admin.center.edit',compact('center'));
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
        try{
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'contact_person' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
            ]);
            
            $center = Center::findOrFail($id);
            $center->update($request->all());
            toastr()->success('Center Updated Successfully');
            return redirect()->route('admin.center.index');
        }catch (\Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $center = Center::findOrFail($id);
            $center->delete();
            toastr()->success('Center Deleted Successfully');
            return redirect()->route('admin.center.index');
        }catch (\Exception $e)
        {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
}
