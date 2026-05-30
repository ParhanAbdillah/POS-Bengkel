<?php

namespace App\Http\Controllers;

use App\Models\Mechanics;
use Illuminate\Http\Request;

class MechanicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Mechanics::query();
        if (request()->filled('search')) {
            $query->where('name_mechanic', 'like', '%' . request()->search . '%');
        }
        $mechanics = $query->get();
        return view('mechanics.index', compact('mechanics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mechanics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_mechanic' => 'required|string|max:30',
            'phone_mechanic' => 'required|string|max:15',
            'address_mechanic' => 'required|string|max:50',
            'status_mechanic' => 'required|in:aktif,nonaktif',
        ], [
            'name_mechanic.required' => 'Nama mekanik wajib diisi.',
            'name_mechanic.string' => 'Nama mekanik harus berupa string.',
            'name_mechanic.max' => 'Nama mekanik tidak boleh lebih dari 30 karakter.',
            'phone_mechanic.required' => 'Nomor telepon mekanik wajib diisi.',
            'phone_mechanic.string' => 'Nomor telepon mekanik harus berupa string.',
            'phone_mechanic.max' => 'Nomor telepon mekanik tidak boleh lebih dari 15 karakter.',
            'address_mechanic.required' => 'Alamat mekanik wajib diisi.',
            'address_mechanic.string' => 'Alamat mekanik harus berupa string.',
            'address_mechanic.max' => 'Alamat mekanik tidak boleh lebih dari 50 karakter.',
            'status_mechanic.required' => 'Status mekanik wajib diisi.',
            'status_mechanic.in' => 'Status mekanik harus bernilai "aktif" atau "nonaktif".',
        ]);

        $store = Mechanics::create([
            'name_mechanic' => $request->name_mechanic,
            'phone_mechanic' => $request->phone_mechanic,
            'address_mechanic' => $request->address_mechanic,
            'status_mechanic' => $request->status_mechanic,
        ]);

        if ($store) {
            return redirect('/mechanics')->with('success', 'Mekanik berhasil ditambahkan.');
        } else {
            return redirect('/mechanics')->with('error', 'Gagal menambahkan mekanik.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mechanics $mechanics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mechanics $mechanic)
    {
        return view('mechanics.edit', compact('mechanic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mechanics $mechanic)
    {
        $request->validate([
            'name_mechanic' => 'required|string|max:30',
            'phone_mechanic' => 'required|string|max:15',
            'address_mechanic' => 'required|string|max:50',
            'status_mechanic' => 'required|in:aktif,nonaktif',
        ], [
            'name_mechanic.required' => 'Nama mekanik wajib diisi.',
            'name_mechanic.string' => 'Nama mekanik harus berupa string.',
            'name_mechanic.max' => 'Nama mekanik tidak boleh lebih dari 30 karakter.',
            'phone_mechanic.required' => 'Nomor telepon mekanik wajib diisi.',
            'phone_mechanic.string' => 'Nomor telepon mekanik harus berupa string.',
            'phone_mechanic.max' => 'Nomor telepon mekanik tidak boleh lebih dari 15 karakter.',
            'address_mechanic.required' => 'Alamat mekanik wajib diisi.',
            'address_mechanic.string' => 'Alamat mekanik harus berupa string.',
            'address_mechanic.max' => 'Alamat mekanik tidak boleh lebih dari 50 karakter.',
            'status_mechanic.required' => 'Status mekanik wajib diisi.',
            'status_mechanic.in' => 'Status mekanik harus bernilai "aktif" atau "nonaktif".',
        ]);

        $update = $mechanic->update([
            'name_mechanic' => $request->name_mechanic,
            'phone_mechanic' => $request->phone_mechanic,
            'address_mechanic' => $request->address_mechanic,
            'status_mechanic' => $request->status_mechanic,
        ]);

        if ($update) {
            return redirect('/mechanics')->with('success', 'Mekanik berhasil diperbarui.');
        } else {
            return redirect('/mechanics')->with('error', 'Gagal memperbarui mekanik.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mechanics $mechanic)
    {
        $delete = $mechanic->delete();

        if ($delete) {
            return redirect('/mechanics')->with('success', 'Mekanik berhasil dihapus.');
        } else {
            return redirect('/mechanics')->with('error', 'Gagal menghapus mekanik.');
        }
    }
}
