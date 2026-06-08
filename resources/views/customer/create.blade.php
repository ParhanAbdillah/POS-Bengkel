<form action="{{route('customers.store')}}" method="POST">
    @csrf
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-user"></i></span>
        <input type="text" class="form-control" name="name" placeholder="Nama Pelanggan" aria-label="Nama Pelanggan" required>
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-phone"></i></span>
        <input type="text" class="form-control" name="phone" placeholder="No Telepon" aria-label="No Telepon">
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-map-pin"></i></span>
        <textarea class="form-control" name="address" placeholder="Alamat Pelanggan" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
