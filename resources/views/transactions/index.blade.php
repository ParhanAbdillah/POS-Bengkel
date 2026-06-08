@extends('layouts.app')
@section('title', 'Transaksi Servis')
@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table border-top" id="transactionsTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>No. Invoice</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-semibold text-heading">{{ $item->invoice_number }}</span></td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->vehicle->customer->name ?? '-' }}</td>
                            <td>{{ $item->vehicle->plate_number ?? '-' }} - {{ $item->vehicle->model_name ?? '-' }}</td>
                            <td>Rp {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status == 'antre')
                                    <span class="badge bg-label-secondary">Antre</span>
                                @elseif($item->status == 'proses')
                                    <span class="badge bg-label-warning">Proses</span>
                                @elseif($item->status == 'menunggu_sparepart')
                                    <span class="badge bg-label-danger">Menunggu Sparepart</span>
                                @elseif($item->status == 'bisa_diambil')
                                    <span class="badge bg-label-info">Bisa Diambil</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-label-success">Selesai</span>
                                @else
                                    <span class="badge bg-label-dark">Batal</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('transactions.edit', $item->id) }}" class="btn btn-sm btn-icon btn-label-primary" title="Kelola Transaksi">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    customClass: { confirmButton: 'btn btn-primary' },
                    buttonsStyling: false
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    customClass: { confirmButton: 'btn btn-primary' },
                    buttonsStyling: false
                });
            @endif
            var dt = $('#transactionsTable').DataTable({
                dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Kendaraan Masuk</span>',
                    className: 'create-new btn btn-primary waves-effect waves-light',
                    action: function() {
                        window.location.href = "{{ route('transactions.create') }}";
                    }
                }],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                    infoFiltered: '(disaring dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada data yang cocok ditemukan',
                    paginate: {
                        next: '<i class="ti ti-chevron-right"></i>',
                        previous: '<i class="ti ti-chevron-left"></i>'
                    }
                }
            });
            $('div.head-label').html('<h5 class="card-title mb-0">Daftar Transaksi Kasir</h5>');
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data transaksi yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        })
    </script>
@endpush
