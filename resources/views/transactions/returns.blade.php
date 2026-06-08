@extends('layouts.app')
@section('title', 'Pengembalian Servis')
@section('content')
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table border-top" id="returnsTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No. Antrian</th>
                        <th>No. Invoice</th>
                        <th>Tanggal Masuk</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $item)
                        <tr>
                            <td class="text-center"><h4>{{ $item->id }}</h4></td>
                            <td><span class="fw-semibold text-heading">{{ $item->invoice_number }}</span></td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->vehicle->customer->name ?? '-' }}</td>
                            <td>{{ $item->vehicle->plate_number ?? '-' }} - {{ $item->vehicle->model_name ?? '-' }}</td>
                            <td>Rp {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status == 'bisa_diambil')
                                    <span class="badge bg-label-info">Bisa Diambil</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-label-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-icon btn-success btn-voice-modal me-2" 
                                    data-no="{{ $item->id }}" 
                                    data-nama="{{ $item->vehicle->customer->name ?? 'Pelanggan' }}" 
                                    data-phone="{{ $item->vehicle->customer->phone ?? '' }}"
                                    title="Panggil Antrian">
                                    <i class="ti ti-volume"></i>
                                </button>
                                <a href="{{ route('transactions.edit', $item->id) }}#checkout-section" class="btn btn-sm btn-icon btn-primary" title="Proses Bayar">
                                    <i class="ti ti-printer"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="voiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Panggilan Suara Untuk Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fw-semibold mb-3">Pemberitahuan Customer</p>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-danger" id="btnPanggilSekarang">
                            <i class="ti ti-player-play me-2"></i> Panggil Sekarang
                        </button>
                        <a href="#" target="_blank" class="btn btn-success" id="btnHubungiSekarang">
                            <i class="ti ti-brand-whatsapp me-2"></i> Hubungi Sekarang
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            var dt = $('#returnsTable').DataTable({
                dom: '<"card-header flex-column flex-md-row p-3 d-flex justify-content-between align-items-center"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mx-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [],
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
            $('div.head-label').html('<h5 class="card-title mb-0">Data Barang Servis Keseluruhan</h5>');

            var currentNoAntrian = '';
            var currentNama = '';

            $(document).on('click', '.btn-voice-modal', function() {
                currentNoAntrian = $(this).data('no');
                currentNama = $(this).data('nama');
                var phone = $(this).data('phone');

                if(phone) {

                    if(phone.startsWith('0')) {
                        phone = '62' + phone.substring(1);
                    }
                    var trackUrl = '{{ url("/track") }}/' + currentNoAntrian;
                    var waText = encodeURIComponent("Kabar gembira Bapak/Ibu " + currentNama + "! Servis kendaraan Anda (Nota: " + currentNoAntrian + ") *telah selesai*. Silakan datang ke kasir Mandiri Motor. Detail lengkap progres: " + trackUrl);
                    $('#btnHubungiSekarang').attr('href', 'https://wa.me/' + phone + '?text=' + waText);
                    $('#btnHubungiSekarang').removeClass('disabled');
                } else {
                    $('#btnHubungiSekarang').attr('href', '#');
                    $('#btnHubungiSekarang').addClass('disabled');
                }
                $('#voiceModal').modal('show');
            });

            $('#btnPanggilSekarang').on('click', function() {
                var msg = new SpeechSynthesisUtterance();
                msg.text = "Panggilan kepada pelanggan dengan nomor antrean " + currentNoAntrian + ", atas nama Bapak atau Ibu " + currentNama + ". Kendaraan Anda telah selesai di-servis. Silakan menuju ke meja kasir untuk melakukan pembayaran. Terima kasih.";
                msg.lang = 'id-ID';
                msg.rate = 0.85; // Sedikit dilambatkan agar terdengar lebih jelas dan profesional
                window.speechSynthesis.speak(msg);
            });
        })
    </script>
@endpush
