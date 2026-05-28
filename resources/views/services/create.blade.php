<form action="{{route ('services.store')}}" method="POST">
    @csrf
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-box"></i></span>
        <input type="text" class="form-control" name="name_service" placeholder="Service Name" aria-label="Search..."
            aria-describedby="basic-addon-search31">
    </div>
    <div class="input-group input-group-merge mb-3">
        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-money"></i></span>
        <input type="number" class="form-control" name="price_service" placeholder="Service Price" aria-label="Search..."
            aria-describedby="basic-addon-search31">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>