<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::all();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_service' => 'required|string|max:30',
            'price_service' => 'required|numeric',
        ],[
            'name_service.required' => 'Nama jasa wajib diisi.',
            'name_service.string' => 'Nama jasa harus berupa string.',
            'name_service.max' => 'Nama jasa tidak boleh lebih dari 30 karakter.',
            'price_service.required' => 'Harga jasa wajib diisi.',
            'price_service.numeric' => 'Harga jasa harus berupa angka.',
        ]);

        $store = Services::create([
            'name_service' => $request->name_service,
            'price_service' => $request->price_service,
        ]);

        if($store){
            return redirect('/services')->with('success', 'Jasa berhasil ditambahkan.');
        } else {
            return redirect('/services')->with('error', 'Gagal menambahkan jasa.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Services $service)
    {
        $request->validate([
            'name_service' => 'required|string|max:30',
            'price_service' => 'required|numeric',
        ],[
            'name_service.required' => 'Nama jasa wajib diisi.',
            'name_service.string' => 'Nama jasa harus berupa string.',
            'name_service.max' => 'Nama jasa tidak boleh lebih dari 30 karakter.',
            'price_service.required' => 'Harga jasa wajib diisi.',
            'price_service.numeric' => 'Harga jasa harus berupa angka.',
        ]);

        $update = $service->update([
            'name_service' => $request->name_service,
            'price_service' => $request->price_service,
        ]);

        if($update){
            return redirect('/services')->with('success', 'Jasa berhasil diperbarui.');
        } else {
            return redirect('/services')->with('error', 'Gagal memperbarui jasa.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $service)
    {
        $delete = $service->delete();

        if($delete){
            return redirect('/services')->with('success', 'Jasa berhasil dihapus.');
        } else {
            return redirect('/services')->with('error', 'Gagal menghapus jasa.');
        }
    }
}
