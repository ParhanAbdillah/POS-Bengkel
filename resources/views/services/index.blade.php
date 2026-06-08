@extends('layouts.app')
@section('title', 'Service')
@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table border-top" id="servicesTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama Service</th>
                        <th>Harga Service</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-semibold text-heading">{{ $item->name_service }}</span></td>
                            <td>Rp {{ number_format($item->price_service, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-icon btn-label-primary btn-edit me-2"
                                    data-url="{{ route('services.edit', $item->id) }}" title="Edit">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <form action="{{ route('services.destroy', $item->id) }}" method="POST"
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
    <div class="modal fade" id="servicemodal" tabindex="-1" aria-hidden="true">
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

                var dt = $('#servicesTable').DataTable({
                    dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [{
                        text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Tambah Service</span>',
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

                $('div.head-label').html('<h5 class="card-title mb-0">Data Service</h5>');
                $(document).on('click', '#btnAdd', function(e) {
                    e.preventDefault();
                    $('#titlemodal').text('Tambah Service');
                    $('#loadForm').load("{{ route('services.create') }}");
                    $('#servicemodal').modal('show');
                });

                $(document).on('click', '.btn-edit', function(e) {
                    e.preventDefault();
                    var url = $(this).data('url');
                    $('#titlemodal').text('Edit Service');
                    $('#loadForm').load(url);
                    $('#servicemodal').modal('show');
                });

                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kategori yang dihapus tidak dapat dikembalikan!",
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
