<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPropertyController extends Controller
{
    /**
     * Display a listing of the properties in the admin panel.
     */
    public function index()
    {
        $properties = Property::with('propertyType')->latest()->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }

        Property::create($validated);

        return redirect()->route('admin.properties.index')
                         ->with('success', 'Property created successfully.');
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
            'price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($property->featured_image && file_exists(public_path($property->featured_image))) {
                unlink(public_path($property->featured_image));
            }
            $validated['featured_image'] = $this->handleImageUpload($request->file('featured_image'));
        }

        $property->update($validated);

        return redirect()->route('admin.properties.index')
                         ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        if ($property->featured_image && file_exists(public_path($property->featured_image))) {
            unlink(public_path($property->featured_image));
        }
        
        $property->delete();

        return redirect()->route('admin.properties.index')
                         ->with('success', 'Property deleted successfully.');
    }

    /**
     * Handle the upload of a property image.
     */
    protected function handleImageUpload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('properties'), $filename);
        return 'properties/' . $filename;
    }
}
