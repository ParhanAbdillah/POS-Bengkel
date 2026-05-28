<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-box"></i></span>
        <input type="text" class="form-control" name="name_category" placeholder="Nama Kategori" aria-label="Nama Kategori"
            aria-describedby="basic-addon-search31" value="{{ $category->name_category }}" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
</form>