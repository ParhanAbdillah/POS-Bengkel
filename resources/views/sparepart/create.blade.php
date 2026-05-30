<form action="{{route('spareparts.store')}}" method="POST">
    @csrf
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-category"></i></span>
        <select class="form-control" name="category_id" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name_category }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-barcode"></i></span>
        <input type="text" class="form-control" name="sku" placeholder="Code SKU" aria-label="Code SKU" required>
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-box"></i></span>
        <input type="text" class="form-control" name="name_sparepart" placeholder="Nama Sparepart" aria-label="Nama Sparepart" required>
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-tag"></i></span>
        <input type="text" class="form-control" name="brand_sparepart" placeholder="Merk Sparepart" aria-label="Merk Sparepart" required>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="input-group input-group-merge mb-3">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-layers"></i></span>
                <input type="number" class="form-control" name="stock_sparepart" placeholder="Stok" value="0" min="0" required>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group input-group-merge mb-3">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-layers-linked"></i></span>
                <input type="number" class="form-control" name="min_stock_sparepart" placeholder="Min Stok" value="5" min="0" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="input-group input-group-merge mb-3">
                <span class="input-group-text" id="basic-addon-search31">Rp</span>
                <input type="number" class="form-control" name="purchase_price" placeholder="Harga Beli" min="0" required>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group input-group-merge mb-3">
                <span class="input-group-text" id="basic-addon-search31">Rp</span>
                <input type="number" class="form-control" name="selling_price" placeholder="Harga Jual" min="0" required>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>