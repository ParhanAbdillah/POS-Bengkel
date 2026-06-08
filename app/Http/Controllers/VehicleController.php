<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Customer;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('customer')->orderBy('created_at', 'desc')->get();
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('vehicles.index', compact('vehicles', 'customers'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|unique:vehicles,plate_number|max:20',
            'brand' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'model_name' => 'nullable|string|max:50',
            'manufacture_year' => 'nullable|integer',
            'assembly_year' => 'nullable|integer',
            'cylinder' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:30',
            'chassis_number' => 'nullable|string|max:100',
            'engine_number' => 'nullable|string|max:100',
            'description' => 'nullable|string'
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil ditambahkan.');
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'model_name' => 'nullable|string|max:50',
            'manufacture_year' => 'nullable|integer',
            'assembly_year' => 'nullable|integer',
            'cylinder' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:30',
            'chassis_number' => 'nullable|string|max:100',
            'engine_number' => 'nullable|string|max:100',
            'description' => 'nullable|string'
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Data Kendaraan berhasil dihapus.');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|unique:vehicles,plate_number|max:20',
            'brand' => 'nullable|string|max:50',
            'type' => 'nullable|string|max:50',
            'model_name' => 'nullable|string|max:50',
            'manufacture_year' => 'nullable|integer',
            'assembly_year' => 'nullable|integer',
            'cylinder' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:30',
            'chassis_number' => 'nullable|string|max:100',
            'engine_number' => 'nullable|string|max:100',
            'description' => 'nullable|string'
        ]);

        $vehicle = Vehicle::create($request->all());
        $vehicle->load('customer');

        return response()->json([
            'success' => true,
            'data' => $vehicle,
            'message' => 'Kendaraan berhasil ditambahkan'
        ]);
    }
}
