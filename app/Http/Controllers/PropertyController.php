<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('location')->paginate(15);
        return response()->json($properties);
    }
    public function show(Property $property)
    {
        return response()->json($property->load('location'));
    }
}
