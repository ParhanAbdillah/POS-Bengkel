@extends('layouts.app')
@section('title', 'Penjualan Produk (Langsung)')
@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success mx-4 mt-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mx-4 mt-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-datatable table-responsive pt-0">
            <table class="table border-top" id="salesTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td><span class="fw-semibold">{{ $sale->invoice_number }}</span></td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                {{ $sale->customer_name ?: 'Umum' }}
                                @if($sale->customer_phone)
                                    <br><small class="text-muted">{{ $sale->customer_phone }}</small>
                                @endif
                            </td>
                            <td>Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                            <td>
                                @if($sale->payment_method == 'qris')
                                    <span class="badge bg-label-info">QRIS</span>
                                @else
                                    <span class="badge bg-label-success">CASH</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('product-sales.print', $sale->id) }}" target="_blank" class="btn btn-sm btn-icon btn-primary" title="Print Nota">
                                    <i class="ti ti-printer"></i>
                                </a>
                                <form action="{{ route('product-sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-icon btn-danger btn-delete" title="Batalkan Transaksi">
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
@endsection
@push('myscript')
    <script>
        $(function() {
            var dt = $('#salesTable').DataTable({
                dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    {
                        text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Transaksi Baru</span>',
                        className: 'create-new btn btn-primary',
                        action: function ( e, dt, node, config ) {
                            window.location.href = "{{ route('product-sales.create') }}";
                        }
                    }
                ],
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
            $('div.head-label').html('<h5 class="card-title mb-0">Riwayat Penjualan Produk (Langsung)</h5>');
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Batalkan Transaksi?',
                    text: "Stok akan dikembalikan. Aksi ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea5455',
                    cancelButtonColor: '#82868b',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        })
    </script>
@endpush
