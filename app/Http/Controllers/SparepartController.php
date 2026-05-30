<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Category;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Sparepart::with('category');
        if (request()->filled('search')) {
            $query->where('name_sparepart', 'like', '%' . request()->search . '%')
                  ->orWhere('sku', 'like', '%' . request()->search . '%');
        }
        $spareparts = $query->get();
        return view('sparepart.index', compact('spareparts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('sparepart.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:spareparts,sku',
            'name_sparepart' => 'required|string|max:50',
            'brand_sparepart' => 'required|string|max:30',
            'stock_sparepart' => 'required|numeric|min:0',
            'min_stock_sparepart' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $store = Sparepart::create($request->all());

        if ($store) {
            return redirect('/spareparts')->with('success', 'Sparepart berhasil ditambahkan.');
        } else {
            return redirect('/spareparts')->with('error', 'Gagal menambahkan sparepart.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sparepart $sparepart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sparepart $sparepart)
    {
        $categories = Category::all();
        return view('sparepart.edit', compact('sparepart', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:spareparts,sku,' . $sparepart->id,
            'name_sparepart' => 'required|string|max:50',
            'brand_sparepart' => 'required|string|max:30',
            'stock_sparepart' => 'required|numeric|min:0',
            'min_stock_sparepart' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $update = $sparepart->update($request->all());

        if ($update) {
            return redirect('/spareparts')->with('success', 'Sparepart berhasil diperbarui.');
        } else {
            return redirect('/spareparts')->with('error', 'Gagal memperbarui sparepart.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sparepart $sparepart)
    {
        $delete = $sparepart->delete();

        if ($delete) {
            return redirect('/spareparts')->with('success', 'Sparepart berhasil dihapus.');
        } else {
            return redirect('/spareparts')->with('error', 'Gagal menghapus sparepart.');
        }
    }
}
