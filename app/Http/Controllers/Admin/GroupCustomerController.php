<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupCustomer;
use App\Models\BusinessOwner;
use Illuminate\Http\Request;

class GroupCustomerController extends Controller
{
    public function index()
    {
        $module_type = 'grocery';
        $groupCustomers = GroupCustomer::with('businessOwner')->get();
        $businessOwners = BusinessOwner::all();
        return view('admin-views.group-customers.index', compact('groupCustomers','businessOwners','module_type'));
    }

    public function create()
    {
        $businessOwners = BusinessOwner::all();
        return view('admin-views.group-customers.create', compact('businessOwners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'business_owner_id' => 'required|exists:business_owners,id',
        ]);
       
        GroupCustomer::create($request->all());

        return redirect()->route('admin.group-customers.index')->with('success', 'Group Customer created successfully.');
    }

    public function show(GroupCustomer $groupCustomer)
    {
        return view('admin-views.group-customers.show', compact('groupCustomer'));
    }


    public function edit( $id)
    {
        $module_type = 'grocery';
          // Find the BusinessOwner by ID
          $groupCustomer = GroupCustomer::findOrFail($id);
          $businessOwners = BusinessOwner::all();
    
        return view('admin-views.businessowners.edit', compact('groupCustomer','businessOwners','module_type'));
    }
    public function update(Request $request, $id)
    {
        try {
            // Find BusinessOwner by ID
            $GroupCustomer = GroupCustomer::findOrFail($id);
    
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'business_owner_id' => 'required|exists:business_owners,id',
            ]);
    
            // Update BusinessOwner
            $GroupCustomer->update($validated);
    
            return redirect()->route('admin.group-customers.index')->with('success', 'Business Owner updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.group-customers.index')->with('error', 'Failed to update Business Owner!');
        }
    }
    

  
  
    public function destroy($id)
    {
        try {
            // Find the BusinessOwner by ID
            $groupCustomer = GroupCustomer::findOrFail($id);
    
            // Delete the record
            $groupCustomer->delete();
    
            return redirect()->route('admin.group-customers.index')->with('success', 'Group Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.group-customers.index')->with('error', 'Failed to delete Business Owner!');
        }
    }
}

