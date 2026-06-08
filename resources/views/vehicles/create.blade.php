@extends('layouts.app')
@section('title', 'Tambah Data Kendaraan')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-4">
            <h5 class="card-header bg-primary text-white mb-3">Tambah Data Kendaraan</h5>
            <div class="card-body">
                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="customer_id">Nama Customer</label>
                            <select id="customer_id" class="form-select" name="customer_id" required>
                                <option value="">-- Pilih Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} - WA {{ $customer->phone }}</option>
                                @endforeach
                            </select>

                            <div class="mt-2">
                                <a href="javascript:void(0);" class="text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddCustomer">Tambah Customer +</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="plate_number">No. Pol</label>
                            <input type="text" class="form-control" id="plate_number" name="plate_number" placeholder="Contoh: Z 1234 AB" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="brand">Merek</label>
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Contoh: Honda, Yamaha, Toyota" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="type">Tipe</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="Contoh: Matic, Manual, Sport" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="model_name">Jenis</label>
                            <input type="text" class="form-control" id="model_name" name="model_name" placeholder="Contoh: Beat, Vario, Avanza" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="manufacture_year">Tahun Buat</label>
                            <input type="number" class="form-control" id="manufacture_year" name="manufacture_year" placeholder="Contoh: 2022" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="assembly_year">Tahun Rakit</label>
                            <input type="number" class="form-control" id="assembly_year" name="assembly_year" placeholder="Contoh: 2021" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="cylinder">Silinder</label>
                            <input type="text" class="form-control" id="cylinder" name="cylinder" placeholder="Contoh: 2, 4, atau 6 Silinder" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="color">Warna</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="Contoh: Hitam, Putih, Merah" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="chassis_number">No. Rangka</label>
                            <input type="text" class="form-control" id="chassis_number" name="chassis_number" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="engine_number">No. Mesin</label>
                            <input type="text" class="form-control" id="engine_number" name="engine_number" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="description">Keterangan</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Tambahkan catatan khusus untuk kendaraan..."></textarea>
                        </div>
                    </div>
                    <div class="pt-4 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddCustomer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel1">Tambah Data Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAddCustomer">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap pelanggan">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Jln. Pendidikan, Kec. Ciawi, Kab. Tasikmalaya"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" name="phone" class="form-control" placeholder="Contoh: 081234567890">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email (Tidak Wajib)</label>
                    <input type="email" name="email" class="form-control" placeholder="Contoh: email@domain.com">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSaveCustomer">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('myscript')
<script>
$(document).ready(function() {
    $('#btnSaveCustomer').click(function() {
        var formData = $('#formAddCustomer').serialize();
        $.ajax({
            url: "{{ route('customers.storeAjax') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {

                    $('#modalAddCustomer').modal('hide');

                    $('#formAddCustomer')[0].reset();

                    var newOption = new Option(response.data.name + ' - WA ' + (response.data.phone || '-'), response.data.id, true, true);
                    $('#customer_id').append(newOption).trigger('change');
                    Swal.fire('Berhasil!', response.message, 'success');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Gagal menambahkan customer. Periksa inputan Anda.', 'error');
            }
        });
    });
});
</script>
@endpush
