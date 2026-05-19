<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index(Request $request)
    {
        $query = Property::with('propertyType')->latest();

        // Optional filtering by city
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Optional filtering by type
        if ($request->filled('type')) {
            $query->where('property_type_id', $request->type);
        }

        $properties = $query->paginate(9)->withQueryString();
        $propertyTypes = PropertyType::all();

        return view('properties.index', compact('properties', 'propertyTypes'));
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property)
    {
        $property->load('propertyType');
        return view('properties.show', compact('property'));
    }
}
