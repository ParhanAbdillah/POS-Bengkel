<form action="{{route ('mechanics.store')}}" method="POST">
    @csrf
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-box"></i></span>
        <input type="text" class="form-control" name="name_mechanic" placeholder="Mechanic Name" aria-label="Search..."
            aria-describedby="basic-addon-search31">
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-phone"></i></span>
        <input type="text" class="form-control" name="phone_mechanic" placeholder="Phone Number" aria-label="Search..."
            aria-describedby="basic-addon-search31">
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-map-pin"></i></span>
        <input type="text" class="form-control" name="address_mechanic" placeholder="Address" aria-label="Search..."
            aria-describedby="basic-addon-search31">
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-check"></i></span>
        <select class="form-control" name="status_mechanic" aria-label="Search..." aria-describedby="basic-addon-search31">
            <option value="">Select Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>