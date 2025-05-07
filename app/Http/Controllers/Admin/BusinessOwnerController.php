<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessOwner;
use Illuminate\Http\Request;

class BusinessOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module_type = 'grocery';
        $businessOwners = BusinessOwner::all();
        return view('admin-views.businessowners.index', compact('businessOwners','module_type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $module_type = 'grocery';
        return view('admin-views.businessowners.index', compact('businessOwners','module_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);


        BusinessOwner::create($validated);
    
        return redirect()->back()->with('success', 'Business Owner created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessOwner $businessOwner)
    {
        return view('admin-views.businessowners.show', compact('businessOwner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessOwner $businessOwner , $id)
    {
        $module_type = 'grocery';
          // Find the BusinessOwner by ID
          $businessOwner = BusinessOwner::findOrFail($id);
    
        return view('admin-views.businessowners.edit', compact('businessOwner','module_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        // Find BusinessOwner by ID
        $businessOwner = BusinessOwner::findOrFail($id);

        // Validate request
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        // Update BusinessOwner
        $businessOwner->update($validated);

        return redirect()->route('admin.businessowners.index')->with('success', 'Business Owner updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('admin.businessowners.index')->with('error', 'Failed to update Business Owner!');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the BusinessOwner by ID
            $businessOwner = BusinessOwner::findOrFail($id);
    
            // Delete the record
            $businessOwner->delete();
    
            return redirect()->route('admin.businessowners.index')->with('success', 'Business Owner deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.businessowners.index')->with('error', 'Failed to delete Business Owner!');
        }
    }
    
    
}
