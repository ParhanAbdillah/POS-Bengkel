@extends('layouts.app')
@section('title', 'Penerimaan Servis')
@section('content')
<div class="card mb-4">
    <div class="card-datatable table-responsive pt-0">
        <table class="table border-top" id="transactionsTable">
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>No. Antrian</th>
                    <th>Customer</th>
                    <th>No. Pol</th>
                    <th>Kendaraan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th style="width: 180px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->vehicle->customer->name ?? '-' }}</td>
                        <td>{{ $item->vehicle->plate_number ?? '-' }}</td>
                        <td>{{ $item->vehicle->brand ?? '' }} {{ $item->vehicle->type ?? '' }} {{ $item->vehicle->model_name ?? '' }}</td>
                        <td>{{ $item->service_type ?? '-' }}</td>
                        <td>
                            @if($item->status == 'antre')
                                <span class="badge bg-secondary">Antrian Servis Masuk</span>
                            @elseif($item->status == 'proses')
                                <span class="badge bg-warning">Proses</span>
                            @elseif($item->status == 'menunggu_sparepart')
                                <span class="badge bg-danger">Menunggu Sparepart</span>
                            @elseif($item->status == 'bisa_diambil')
                                <span class="badge bg-info">Bisa Diambil</span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-dark">Batal</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $waTextRow = "*TANDA TERIMA SERVIS* Mandiri Motor\n";
                                $waTextRow .= "---------------------------------\n";
                                $waTextRow .= "No. Antrian Servis: {$item->id}\n";
                                $waTextRow .= "Nama: " . ($item->vehicle->customer->name ?? '-') . "\n";
                                $waTextRow .= "Tgl. Diterima: " . $item->created_at->format('d F Y') . "\n";
                                $waTextRow .= "Tlpn: " . ($item->vehicle->customer->phone ?? '-') . "\n";
                                $waTextRow .= "Alamat: " . ($item->vehicle->customer->address ?? '-') . "\n";
                                $waTextRow .= "---------------------------------\n";
                                $waTextRow .= "Kendaraan: " . ($item->vehicle->plate_number ?? '-') . " " . ($item->vehicle->brand ?? '') . " " . ($item->vehicle->type ?? '') . "\n";
                                $waTextRow .= "---------------------------------\n";
                                $waTextRow .= "Cek Servis: " . url('/');
                            @endphp
                            <a href="{{ route('transactions.edit', $item->id) }}" class="btn btn-sm btn-primary btn-icon" title="Edit">
                                <i class="ti ti-edit"></i>
                            </a>
                            <a href="{{ route('transactions.print', $item->id) }}" target="_blank" class="btn btn-sm btn-warning btn-icon" title="Print">
                                <i class="ti ti-printer"></i>
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->vehicle->customer->phone ?? '') }}?text={{ urlencode($waTextRow) }}" target="_blank" class="btn btn-sm btn-success btn-icon" title="WhatsApp">
                                <i class="ti ti-brand-whatsapp"></i>
                            </a>
                            <form action="{{ route('transactions.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Hapus">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahServis" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Data Servis Masuk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="vehicle_id">No. Polisi *</label>
                    <select id="vehicle_id" class="form-select" name="vehicle_id" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->customer->name ?? '' }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <a href="javascript:void(0);" class="text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAddCustomer" data-bs-dismiss="modal">Tambah Kendaraan +</a>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="service_category">Kategori Servis *</label>
                    <select id="service_category" class="form-select" name="service_category" required>
                        <option value="Motor">Motor</option>
                        <option value="Mobil">Mobil</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="complaint">Kerusakan *</label>
                    <input type="text" class="form-control" id="complaint" name="complaint" placeholder="Contoh: Mesin tidak bisa dihidupkan, Rem blong, dll." required />
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="description">Keterangan/Keluhan *</label>
                    <textarea class="form-control" id="description" name="description" rows="2" placeholder="Jelaskan detail keluhan kendaraan..." required></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="vehicle_condition">Kondisi Kendaraan Masuk *</label>
                    <input type="text" class="form-control" id="vehicle_condition" name="vehicle_condition" placeholder="Contoh: Mesin menyala, mogok, dll." required />
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="current_km">KM Sekarang</label>
                    <input type="number" class="form-control" id="current_km" name="current_km" placeholder="Masukkan estimasi KM saat ini" />
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label text-danger" for="service_type">Tipe Servis *</label>
                    <select id="service_type" class="form-select" name="service_type" required>
                        <option value="Datang Langsung Ke Bengkel">Datang Langsung Ke Bengkel</option>
                        <option value="Booking Servis">Booking Servis</option>
                        <option value="Panggilan Darurat">Panggilan Darurat</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label" for="dp">DP</label>
                    <input type="number" class="form-control" id="dp" name="dp" placeholder="Masukkan nominal DP (Opsional)" />
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
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
        <form id="formAddVehicle">
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
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalTambahServis">Kembali</button>
        <button type="button" class="btn btn-primary" id="btnSaveVehicle">Submit Kendaraan</button>
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

@if(session('new_transaction'))
@php
    $trxId = session('new_transaction')['id'];
    $trx = \App\Models\Transaction::with('vehicle.customer')->find($trxId);
    $waText = "";
    if($trx) {
        $waText = "*TANDA TERIMA SERVIS* Mandiri Motor\n";
        $waText .= "---------------------------------\n";
        $waText .= "No. Antrian Servis: {$trx->id}\n";
        $waText .= "Nama: " . ($trx->vehicle->customer->name ?? '-') . "\n";
        $waText .= "Tgl. Diterima: " . $trx->created_at->format('d F Y') . "\n";
        $waText .= "Tlpn: " . ($trx->vehicle->customer->phone ?? '-') . "\n";
        $waText .= "Alamat: " . ($trx->vehicle->customer->address ?? '-') . "\n";
        $waText .= "---------------------------------\n";
        $waText .= "Kendaraan: " . ($trx->vehicle->plate_number ?? '-') . " " . ($trx->vehicle->brand ?? '') . " " . ($trx->vehicle->type ?? '') . "\n";
        $waText .= "---------------------------------\n";
        $waText .= "Cek Servis: " . url('/');
    }
@endphp
<div class="modal fade" id="modalPrintNota" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Print Nota & WhatsApp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-4">No. Antrean: <strong>{{ session('new_transaction')['invoice_number'] }}</strong></p>
        <a href="{{ route('transactions.print', $trxId) }}" target="_blank" class="btn btn-warning mb-2 w-100"><i class="ti ti-printer me-1"></i> Print No. Antrian</a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $trx->vehicle->customer->phone ?? '') }}?text={{ urlencode($waText) }}" target="_blank" class="btn btn-success w-100"><i class="ti ti-brand-whatsapp me-1"></i> No. Antrian WA</a>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
@push('myscript')
<script>
$(document).ready(function() {

    var dt = $('#transactionsTable').DataTable({
        dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
            text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Tambah Data</span>',
            className: 'create-new btn btn-primary waves-effect waves-light',
            action: function() {
                $('#modalTambahServis').modal('show');
            }
        }],
        language: {
            search: 'Search:',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            paginate: {
                next: '<i class="ti ti-chevron-right"></i>',
                previous: '<i class="ti ti-chevron-left"></i>'
            }
        }
    });
    $('div.head-label').html('<h5 class="card-title mb-0">Data Servis Masuk</h5>');

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

    $('#btnSaveVehicle').click(function() {
        var formData = $('#formAddVehicle').serialize();
        $.ajax({
            url: "{{ route('vehicles.storeAjax') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#modalAddVehicle').modal('hide');
                    $('#formAddVehicle')[0].reset();
                    var newOption = new Option(response.data.plate_number + ' - ' + (response.data.customer ? response.data.customer.name : ''), response.data.id, true, true);
                    $('#vehicle_id').append(newOption).trigger('change');
                    $('#modalTambahServis').modal('show');
                    Swal.fire('Berhasil!', response.message, 'success');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Gagal menambahkan kendaraan.', 'error');
            }
        });
    });
    @if(session('success') && !session('new_transaction'))
        Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
    @endif
    @if(session('new_transaction'))
        $('#modalPrintNota').modal('show');
    @endif
});
</script>
@endpush
