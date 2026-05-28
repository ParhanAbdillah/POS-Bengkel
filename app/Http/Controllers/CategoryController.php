<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->filled('search')) {
            $query->where('name_category', 'like', '%' . $request->search . '%');
        }
        $categories = $query->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_category' => 'required|string|max:30',
        ],[
            'name_category.required' => 'Nama kategori wajib diisi.',
            'name_category.string' => 'Nama kategori harus berupa string.',
            'name_category.max' => 'Nama kategori tidak boleh lebih dari 30 karakter.',
        ]);

        $store = Category::create([
            'name_category' => $request->name_category,
        ]);

        if($store){
            return redirect('/categories')->with('success', 'Kategori berhasil ditambahkan.');
        } else {
            return redirect('/categories')->with('error', 'Gagal menambahkan kategori.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_category' => 'required|string|max:30',
        ],[
            'name_category.required' => 'Nama kategori wajib diisi.',
            'name_category.string' => 'Nama kategori harus berupa string.',
            'name_category.max' => 'Nama kategori tidak boleh lebih dari 30 karakter.',
        ]);

        $update = $category->update([
            'name_category' => $request->name_category,
        ]);

        if($update){
            return redirect('/categories')->with('success', 'Kategori berhasil diupdate.');
        } else {
            return redirect('/categories')->with('error', 'Gagal mengupdate kategori.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $delete = $category->delete();
        if($delete){
            return redirect('/categories')->with('success', 'Data berhasil dihapus');
        }else{
            return redirect('/categories')->with('error', 'Gagal menghapus data');
        }
        
    }
}
