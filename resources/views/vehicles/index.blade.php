@extends('layouts.app')
@section('title', 'Data Kendaraan Servis')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Kendaraan</h5>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modalAddCustomer" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Tambah Data Kendaraan</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No. Polisi</th>
                                <th>Pelanggan</th>
                                <th>Merek/Jenis</th>
                                <th>Tahun Rakit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $k => $v)
                                <tr>
                                    <td>{{ $k + 1 }}</td>
                                    <td><strong>{{ $v->plate_number }}</strong></td>
                                    <td>{{ $v->customer->name ?? '-' }} <br><small class="text-muted">{{ $v->customer->phone ?? '' }}</small></td>
                                    <td>{{ $v->brand }} - {{ $v->model_name }}</td>
                                    <td>{{ $v->assembly_year }}</td>
                                    <td>
                                        <a href="{{ route('vehicles.edit', $v->id) }}" class="btn btn-sm btn-info btn-icon"><i class="ti ti-pencil"></i></a>
                                        <form action="{{ route('vehicles.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kendaraan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data kendaraan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddVehicle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Tambah Data Kendaraan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nama Customer</label>
                    <select id="customer_id_modal" class="form-select" name="customer_id" required>
                        <option value="">-- Pilih Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} - WA {{ $customer->phone }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <a href="javascript:void(0);" class="text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddCustomer" data-bs-dismiss="modal">Tambah Customer +</a>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. Pol</label>
                    <input type="text" name="plate_number" class="form-control" required placeholder="Contoh: Z 1234 AB">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Merek</label>
                    <input type="text" name="brand" class="form-control" placeholder="Contoh: Honda, Yamaha, Toyota">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="type" class="form-control" placeholder="Contoh: Matic, Manual, Sport">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis</label>
                    <input type="text" name="model_name" class="form-control" placeholder="Contoh: Beat, Vario, Avanza">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tahun Buat</label>
                    <input type="number" name="manufacture_year" class="form-control" placeholder="Contoh: 2022">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tahun Rakit</label>
                    <input type="number" name="assembly_year" class="form-control" placeholder="Contoh: 2021">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Silinder</label>
                    <input type="text" name="cylinder" class="form-control" placeholder="Contoh: 2, 4, atau 6 Silinder">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Warna</label>
                    <input type="text" name="color" class="form-control" placeholder="Contoh: Hitam, Putih, Merah">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. Rangka</label>
                    <input type="text" name="chassis_number" class="form-control" placeholder="Masukkan No. Rangka">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. Mesin</label>
                    <input type="text" name="engine_number" class="form-control" placeholder="Masukkan No. Mesin">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="description" class="form-control" rows="1" placeholder="Tambahkan catatan khusus untuk kendaraan..."></textarea>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit Kendaraan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddCustomer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Tambah Data Customer</h5>
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
                    <textarea name="address" class="form-control" rows="1" placeholder="Jln. Pendidikan, Kec. Ciawi, Kab. Tasikmalaya"></textarea>
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
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalAddVehicle">Kembali</button>
        <button type="button" class="btn btn-primary" id="btnSaveCustomer">Submit Customer</button>
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
                    $('#customer_id_modal').append(newOption).trigger('change');

                    $('#modalAddVehicle').modal('show');
                    Swal.fire('Berhasil!', response.message, 'success');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Gagal menambahkan customer.', 'error');
            }
        });
    });
});
</script>
@endpush
