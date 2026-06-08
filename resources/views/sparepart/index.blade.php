@extends('layouts.app')
@section('title', 'Sparepart')
@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table border-top" id="sparepartsTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Code SKU</th>
                        <th>Kategori</th>
                        <th>Nama Sparepart</th>
                        <th>Merk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spareparts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->category->name_category ?? '-' }}</td>
                            <td><span class="fw-semibold text-heading">{{ $item->name_sparepart }}</span></td>
                            <td>{{ $item->brand_sparepart }}</td>
                            <td>Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->selling_price, 0, ',', '.') }}</td>
                            <td>{{ $item->stock_sparepart }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-icon btn-label-primary btn-edit me-2"
                                    data-url="{{ route('spareparts.edit', $item->id) }}" title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('spareparts.destroy', $item->id) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-icon btn-label-danger btn-delete"
                                        title="Hapus">
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
    {{-- MODAL TAMBAH & EDIT DATA --}}
    <div class="modal fade" id="sparepartmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titlemodal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadForm">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $(function() {

                @if (session('success'))
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                @endif

                var dt = $('#sparepartsTable').DataTable({
                    dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [{
                        text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Tambah Sparepart</span>',
                        className: 'create-new btn btn-primary waves-effect waves-light',
                        attr: {
                            'id': 'btnAdd'
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

                $('div.head-label').html('<h5 class="card-title mb-0">Data Sparepart</h5>');
                $(document).on('click', '#btnAdd', function(e) {
                    e.preventDefault();
                    $('#titlemodal').text('Tambah Sparepart');
                    $('#loadForm').load("{{ route('spareparts.create') }}");
                    $('#sparepartmodal').modal('show');
                });

                $(document).on('click', '.btn-edit', function(e) {
                    e.preventDefault();
                    var url = $(this).data('url');
                    $('#titlemodal').text('Edit Sparepart');
                    $('#loadForm').load(url);
                    $('#sparepartmodal').modal('show');
                });

                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data sparepart yang dihapus tidak dapat dikembalikan!",
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
        })
    </script>
@endpush
