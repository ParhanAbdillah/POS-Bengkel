<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Customer::query();
        if (request()->filled('search')) {
            $query->where('name', 'like', '%' . request()->search . '%')
                  ->orWhere('phone', 'like', '%' . request()->search . '%');
        }
        $customers = $query->get();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $store = Customer::create($request->all());

        if ($store) {
            return redirect('/customers')->with('success', 'Pelanggan berhasil ditambahkan.');
        } else {
            return redirect('/customers')->with('error', 'Gagal menambahkan pelanggan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $update = $customer->update($request->all());

        if ($update) {
            return redirect('/customers')->with('success', 'Pelanggan berhasil diperbarui.');
        } else {
            return redirect('/customers')->with('error', 'Gagal memperbarui pelanggan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $delete = $customer->delete();

        if ($delete) {
            return redirect('/customers')->with('success', 'Pelanggan berhasil dihapus.');
        } else {
            return redirect('/customers')->with('error', 'Gagal menghapus pelanggan.');
        }
    }
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $customer = \App\Models\Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status ?? 'Active',
        ]);

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Customer berhasil ditambahkan'
        ]);
    }
}
