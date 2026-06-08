@extends('layouts.app')
@section('title', 'Proses & Kasir Transaksi')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div>
                    Data Servis No. Nota {{ $transaction->id }} - <span class="text-danger fw-bold">No. Antrian {{ $transaction->id }}</span>
                    <div class="fs-6 text-muted mt-1 fw-normal">{{ $transaction->created_at->format('d F Y') }} - Tipe Servis: {{ $transaction->service_type ?? 'Datang Langsung' }}</div>
                </div>
                <div class="fs-6 fw-normal text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted">Home</a> / Data Servis
                </div>
            </h5>
            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" id="formTransaction">
                @csrf
                @method('PUT')
                @if($transaction->status == 'selesai')
                    <div class="alert alert-success m-3 mb-0" role="alert">
                        <h6 class="alert-heading mb-1"><i class="ti ti-check text-success me-1"></i> Transaksi Selesai</h6>
                        <span>Transaksi ini telah selesai dibayar dan tidak dapat diubah lagi. Anda hanya dapat melihat dan mencetak data.</span>
                    </div>
                @endif
                <fieldset {{ $transaction->status == 'selesai' ? 'disabled' : '' }}>
                <div class="card-body mt-3">
                    <div class="card border mb-4">
                        <div class="card-header border-bottom bg-lighter py-3">
                            <h6 class="mb-0 fw-semibold text-secondary">Data Customer & Kendaraan Servis No. Nota {{ $transaction->id }}</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Nama Customer</label>
                                    <input type="text" class="form-control bg-lighter text-secondary" readonly value="{{ $transaction->vehicle->customer->name ?? '-' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Penerima / Tanggal Terima</label>
                                    <input type="text" class="form-control bg-lighter text-secondary" readonly value="{{ auth()->user()->name ?? 'Admin' }} / {{ $transaction->created_at->format('d F Y h:i:s a') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Kategori Servis / No. Pol / Kendaraan</label>
                                    <input type="text" class="form-control bg-lighter text-secondary" readonly value="{{ ucfirst($transaction->service_category) }} / {{ $transaction->vehicle->plate_number ?? '-' }} / {{ $transaction->vehicle->brand ?? '' }} {{ $transaction->vehicle->model_name ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Kerusakan</label>
                                    <input type="text" class="form-control bg-lighter text-secondary" readonly value="{{ $transaction->complaint ?? 'Mesin' }}">
                                </div>
                            </div>
                            <div class="mt-4 pt-2 text-center">
                                <button type="button" class="btn btn-info me-2"><i class="ti ti-settings me-1"></i> Detail Kendaraan Servis</button>
                                <button type="button" class="btn btn-success me-2"><i class="ti ti-user me-1"></i> Identitas Customer</button>
                                <button type="button" class="btn btn-warning"><i class="ti ti-bookmark me-1"></i> Identitas Kendaraan</button>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-tool text-primary"></i> Jasa Servis</h6>
                            @if($transaction->status != 'selesai')
                                <button type="button" class="btn btn-sm btn-primary" id="addService"><i class="ti ti-plus"></i> Tambah Jasa</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableServices">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No.</th>
                                        <th width="150">Kategori Servis</th>
                                        <th>Nama Servis</th>
                                        <th width="200">Mekanik</th>
                                        <th width="150">Biaya</th>
                                        <th width="80" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->detailServices as $index => $ds)
                                    <tr class="service-row">
                                        <td class="row-number">{{ $index + 1 }}</td>
                                        <td>{{ ucfirst($transaction->service_category) }}</td>
                                        <td>
                                            <select name="services[]" class="form-select service-select" required>
                                                <option value="">-- Pilih Jasa --</option>
                                                @foreach($services as $s)
                                                    <option value="{{ $s->id }}" data-price="{{ $s->price_service }}" {{ $ds->service_id == $s->id ? 'selected' : '' }}>{{ $s->name_service }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="mechanics[]" class="form-select mechanic-select" required>
                                                <option value="">-- Pilih Mekanik --</option>
                                                @foreach($mechanics as $m)
                                                    <option value="{{ $m->id }}" {{ $ds->mechanic_id == $m->id ? 'selected' : '' }}>{{ $m->name_mechanic }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control service-price" value="{{ number_format($ds->price_at_transaction, 0, ',', '.') }}" readonly>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($transaction->status != 'selesai')
                                                <button type="button" class="btn btn-icon btn-danger btn-sm remove-row"><i class="ti ti-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-settings text-primary"></i> Sparepart</h6>
                            @if($transaction->status != 'selesai')
                                <button type="button" class="btn btn-sm btn-primary" id="addSparepart"><i class="ti ti-plus"></i> Tambah Sparepart</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableSpareparts">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Sparepart</th>
                                        <th width="150">Harga Satuan</th>
                                        <th width="120">Qty</th>
                                        <th width="200">Subtotal</th>
                                        <th width="80" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->detailSpareparts as $dp)
                                    <tr>
                                        <td>
                                            <select name="spareparts[]" class="form-select sparepart-select" required>
                                                <option value="">-- Pilih Sparepart --</option>
                                                @foreach($spareparts as $sp)
                                                    <option value="{{ $sp->id }}" data-price="{{ $sp->selling_price }}" data-stock="{{ $sp->stock_sparepart }}" {{ $dp->sparepart_id == $sp->id ? 'selected' : '' }}>
                                                        {{ $sp->name_sparepart }} (Stok: {{ $sp->stock_sparepart }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control sparepart-price" value="{{ number_format($dp->price_at_transaction, 0, ',', '.') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="quantities[]" class="form-control sparepart-qty" min="1" value="{{ $dp->quantity }}" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="text" class="form-control sparepart-subtotal" value="{{ number_format($dp->subtotal, 0, ',', '.') }}" readonly>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($transaction->status != 'selesai')
                                                <button type="button" class="btn btn-icon btn-danger btn-sm remove-row"><i class="ti ti-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>

                    <div class="card bg-lighter p-4 border mb-4">
                        <h6 class="fw-bold mb-3">Informasi Servis No. Nota {{ $transaction->id }}</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sub Total Biaya Servis</label>
                                <input type="text" id="lblGrandTotalInput" class="form-control bg-light" readonly value="0">
                                <small class="text-danger fw-semibold mt-1 d-block">Total Biaya Servis Merupakan Penjumlahan Dari Total Biaya Jasa + Total Harga Sparepart</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">DP (Bayar Diawal)</label>
                                <input type="text" class="form-control bg-light" readonly value="{{ number_format($transaction->dp, 0, ',', '.') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Sisa Bayar</label>
                                <input type="text" id="lblSisaBayarInput" class="form-control bg-light" readonly value="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Servis</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="antre" {{ $transaction->status == 'antre' ? 'selected' : '' }}>Antrian Servis Masuk</option>
                                    <option value="proses" {{ $transaction->status == 'proses' ? 'selected' : '' }}>Proses Dikerjakan</option>
                                    <option value="menunggu_sparepart" {{ $transaction->status == 'menunggu_sparepart' ? 'selected' : '' }}>Menunggu Sparepart</option>
                                    <option value="bisa_diambil" {{ $transaction->status == 'bisa_diambil' ? 'selected' : '' }}>Bisa Diambil</option>
                                    <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>Selesai (Bayar)</option>
                                    <option value="cancel" {{ $transaction->status == 'cancel' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Catatan Teknisi (optional)</label>
                                <textarea name="technician_notes" class="form-control" rows="1" placeholder="Tambahkan catatan teknisi di sini...">{{ $transaction->technician_notes ?? '-' }}</textarea>
                            </div>

                            <div class="col-12" id="checkout-fields" style="display: none;">
                                <hr class="my-2">
                                <h6 class="fw-semibold text-primary mb-3"><i class="ti ti-check me-2"></i>Data Pengambilan & Pembayaran</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kondisi Kendaraan Setelah Servis</label>
                                        <input type="text" name="vehicle_condition" class="form-control" placeholder="Jelaskan kondisi aktual kendaraan..." value="{{ $transaction->vehicle_condition }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Servis Berkala (Datang Kembali)</label>
                                        <div class="d-flex gap-2">
                                            <input type="number" name="periodic_service_value" class="form-control w-25" value="{{ $transaction->periodic_service_value ?? '0' }}">
                                            <select name="periodic_service_unit" class="form-select w-75">
                                                <option value="">-- Pilih --</option>
                                                <option value="hari" {{ $transaction->periodic_service_unit == 'hari' ? 'selected' : '' }}>Hari</option>
                                                <option value="bulan" {{ $transaction->periodic_service_unit == 'bulan' ? 'selected' : '' }}>Bulan</option>
                                                <option value="tahun" {{ $transaction->periodic_service_unit == 'tahun' ? 'selected' : '' }}>Tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Pesan WhatsApp Pengingat Servis Berkala</label>
                                        <textarea name="periodic_service_message" class="form-control" rows="2" placeholder="Kendaraan Anda Sudah Waktunya Melakukan Servis Berkala...">{{ $transaction->periodic_service_message ?? 'Kendaraan Anda Sudah Waktunya Melakukan Servis Berkala sesuai dengan tanggal yang sudah ditentukan dari kami.' }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="checkoutSection" class="p-4 bg-label-success rounded d-none mb-4">
                        <h6><i class="ti ti-cash"></i> Pembayaran Kasir</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-success">Metode Pembayaran</label>
                                <select name="payment_method" id="payment_method" class="form-select border-success">
                                    <option value="cash" {{ ($transaction->payment_method ?? 'cash') == 'cash' ? 'selected' : '' }}>Cash / Tunai</option>
                                    <option value="qris" {{ $transaction->payment_method == 'qris' ? 'selected' : '' }}>QRIS / Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-success">Uang Bayar (Rp)</label>
                                <input type="number" id="money_paid" name="money_paid" class="form-control form-control-lg border-success" value="{{ $transaction->money_paid > 0 ? $transaction->money_paid : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-success">Kembalian (Rp)</label>
                                <input type="text" id="money_change" class="form-control form-control-lg bg-transparent border-0 text-success fw-bold" readonly value="{{ $transaction->money_change > 0 ? number_format($transaction->money_change, 0, '', '') : '0' }}">
                            </div>
                        </div>
                    </div>
                </div>
                </fieldset>
                <div class="card-footer border-top text-end pt-4 bg-lighter">
                    @php
                        $customerName = $transaction->vehicle->customer->name ?? 'Pelanggan';
                        $plat = $transaction->vehicle->plate_number ?? '';
                        $invoice = $transaction->invoice_number;
                        $trackUrl = route('transactions.track', $invoice);
                        if($transaction->status == 'antre') {
                            $waText = "Halo Bapak/Ibu $customerName, kendaraan Anda dengan No. Pol $plat telah terdaftar dalam antrean servis kami dengan No. Antrean: $transaction->id. Anda bisa memantau progresnya di sini: $trackUrl";
                        } elseif($transaction->status == 'proses') {
                            $waText = "Halo Bapak/Ibu $customerName, kendaraan Anda (No. Pol $plat) saat ini sedang *mulai dikerjakan* oleh mekanik kami. Pantau progresnya di sini: $trackUrl";
                        } elseif($transaction->status == 'menunggu_sparepart') {
                            $waText = "Halo Bapak/Ibu $customerName, proses servis kendaraan Anda (No. Pol $plat) sedang *menunggu ketersediaan sparepart*. Kami akan segera menginfokan kembali. Cek detail: $trackUrl";
                        } elseif($transaction->status == 'bisa_diambil') {
                            $total = number_format($transaction->grand_total, 0, ',', '.');
                            $waText = "Kabar gembira Bapak/Ibu $customerName! Servis kendaraan Anda (No. Pol $plat) *telah selesai*. Silakan datang ke kasir Mandiri Motor. Total estimasi biaya: Rp $total. Detail lengkap: $trackUrl";
                        } elseif($transaction->status == 'selesai') {
                            $waText = "Terima kasih Bapak/Ibu $customerName telah mempercayakan servis kendaraan Anda di Mandiri Motor. $transaction->periodic_service_message Anda dapat melihat riwayat nota Anda di sini: $trackUrl";
                        } else {
                            $waText = "Halo Bapak/Ibu $customerName, mohon maaf transaksi servis kendaraan Anda (No. Pol $plat) telah *dibatalkan*.";
                        }
                        $waPhone = preg_replace('/[^0-9]/', '', $transaction->vehicle->customer->phone ?? '');
                        if (substr($waPhone, 0, 2) === '08') {
                            $waPhone = '628' . substr($waPhone, 2);
                        }
                        $waUrl = "https://wa.me/" . $waPhone . "?text=" . urlencode($waText);
                    @endphp
                    <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank" class="btn btn-warning me-2"><i class="ti ti-printer me-1"></i> Print Data</a>
                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-success me-2"><i class="ti ti-brand-whatsapp me-1"></i> Info Customer</a>
                    @if($transaction->status != 'selesai')
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="ti ti-device-floppy me-1"></i> Simpan Data</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(document).ready(function() {

        var serviceOptions = '<option value="">-- Pilih Jasa --</option>';
        @foreach($services as $s)
            serviceOptions += '<option value="{{ $s->id }}" data-price="{{ $s->price_service }}">{{ addslashes($s->name_service) }}</option>';
        @endforeach
        var mechanicOptions = '<option value="">-- Pilih Mekanik --</option>';
        @foreach($mechanics as $m)
            mechanicOptions += '<option value="{{ $m->id }}">{{ addslashes($m->name_mechanic) }}</option>';
        @endforeach
        var sparepartOptions = '<option value="">-- Pilih Sparepart --</option>';
        @foreach($spareparts as $sp)
            sparepartOptions += '<option value="{{ $sp->id }}" data-price="{{ $sp->selling_price }}" data-stock="{{ $sp->stock_sparepart }}">{{ addslashes($sp->name_sparepart) }} (Stok: {{ $sp->stock_sparepart }})</option>';
        @endforeach

        $('#addService').click(function() {
            var tbody = $('#tableServices tbody');
            var rowCount = tbody.find('tr').length + 1;
            var category = '{{ ucfirst($transaction->service_category ?? "-") }}';
            var row = `
                <tr class="service-row">
                    <td class="row-number">${rowCount}</td>
                    <td>${category}</td>
                    <td><select name="services[]" class="form-select service-select" required>${serviceOptions}</select></td>
                    <td><select name="mechanics[]" class="form-select mechanic-select" required>${mechanicOptions}</select></td>
                    <td><div class="input-group"><span class="input-group-text">Rp</span><input type="text" class="form-control service-price" readonly value="0"></div></td>
                    <td class="text-center"><button type="button" class="btn btn-icon btn-danger btn-sm remove-row"><i class="ti ti-trash"></i></button></td>
                </tr>
            `;
            tbody.append(row);
            updateRowNumbers();
        });

        $('#addSparepart').click(function() {
            var row = `
                <tr>
                    <td><select name="spareparts[]" class="form-select sparepart-select" required>${sparepartOptions}</select></td>
                    <td><input type="text" class="form-control sparepart-price" readonly value="0"></td>
                    <td><input type="number" name="quantities[]" class="form-control sparepart-qty" min="1" value="1" required></td>
                    <td><div class="input-group"><span class="input-group-text">Rp</span><input type="text" class="form-control sparepart-subtotal" readonly value="0"></div></td>
                    <td class="text-center"><button type="button" class="btn btn-icon btn-danger btn-sm remove-row"><i class="ti ti-trash"></i></button></td>
                </tr>
            `;
            $('#tableSpareparts tbody').append(row);
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            updateRowNumbers();
            calculateTotals();
        });
        function updateRowNumbers() {
            $('#tableServices tbody tr.service-row').each(function(index) {
                $(this).find('.row-number').text(index + 1);
            });
        }
        function formatRupiah(num) {
            return parseInt(num || 0).toLocaleString('id-ID');
        }
        function unformatRupiah(str) {
            if(!str) return 0;
            return parseInt(str.toString().replace(/\./g, '')) || 0;
        }

        $(document).on('change', '.service-select', function() {
            var price = $(this).find('option:selected').data('price') || 0;
            $(this).closest('tr').find('.service-price').val(formatRupiah(price));
            calculateTotals();
        });

        $(document).on('change', '.sparepart-select', function() {
            var price = $(this).find('option:selected').data('price') || 0;
            $(this).closest('tr').find('.sparepart-price').val(formatRupiah(price));
            calcSparepartRow($(this).closest('tr'));
            calculateTotals();
        });

        $(document).on('input', '.sparepart-qty', function() {
            var maxStock = $(this).closest('tr').find('.sparepart-select option:selected').data('stock') || 0;
            var qty = parseInt($(this).val()) || 0;

            if(qty > maxStock && maxStock > 0) {
                Swal.fire('Stok Terbatas', 'Stok sparepart ini hanya tersisa ' + maxStock, 'warning');
                $(this).val(maxStock);
            }
            calcSparepartRow($(this).closest('tr'));
            calculateTotals();
        });
        function calcSparepartRow(row) {
            var price = unformatRupiah(row.find('.sparepart-price').val());
            var qty = parseInt(row.find('.sparepart-qty').val()) || 0;
            var subtotal = price * qty;
            row.find('.sparepart-subtotal').val(formatRupiah(subtotal));
        }
        var grandTotalValue = 0;
        function calculateTotals() {
            var totalService = 0;
            $('.service-price').each(function() {
                totalService += unformatRupiah($(this).val());
            });
            $('#lblTotalService').text(formatRupiah(totalService));
            var totalSparepart = 0;
            $('.sparepart-subtotal').each(function() {
                totalSparepart += unformatRupiah($(this).val());
            });
            $('#lblTotalSparepart').text(formatRupiah(totalSparepart));
            grandTotalValue = totalService + totalSparepart;
            var dpValue = {{ $transaction->dp ?? 0 }};
            var sisaBayar = grandTotalValue - dpValue;
            if(sisaBayar < 0) sisaBayar = 0;
            $('#lblGrandTotalInput').val(grandTotalValue.toLocaleString('id-ID'));
            $('#lblSisaBayarInput').val(sisaBayar.toLocaleString('id-ID'));

            if ($('#payment_method').val() == 'qris') {
                $('#money_paid').val(sisaBayar);
            }
            calcChange(sisaBayar);
        }

        $('#money_paid').on('input', function() {
            var dpValue = {{ $transaction->dp ?? 0 }};
            var sisaBayar = grandTotalValue - dpValue;
            if(sisaBayar < 0) sisaBayar = 0;
            calcChange(sisaBayar);
        });

        $('#payment_method').on('change', function() {
            var method = $(this).val();
            var dpValue = {{ $transaction->dp ?? 0 }};
            var sisaBayar = grandTotalValue - dpValue;
            if(sisaBayar < 0) sisaBayar = 0;
            if (method == 'qris') {
                $('#money_paid').val(sisaBayar);
                $('#money_paid').prop('readonly', true);
            } else {
                $('#money_paid').prop('readonly', false);

            }
            calcChange(sisaBayar);
        });
        function calcChange(sisaBayar) {
            var paid = parseFloat($('#money_paid').val()) || 0;
            var change = paid - sisaBayar;
            if (change < 0) {
                $('#money_change').val('0');
            } else {
                $('#money_change').val(change.toLocaleString('id-ID'));
            }
        }

        calculateTotals();
        toggleCheckoutFields();

        $('#status').on('change', function() {
            toggleCheckoutFields();
        });
        function toggleCheckoutFields() {
            var status = $('#status').val();

            if (status == 'selesai') {
                $('#checkoutSection').removeClass('d-none');
                $('#money_paid').prop('required', true);
            } else {
                $('#checkoutSection').addClass('d-none');
                $('#money_paid').prop('required', false);
            }

            if (status == 'bisa_diambil' || status == 'selesai') {
                $('#checkout-fields').slideDown();
            } else {
                $('#checkout-fields').slideUp();
            }
        }

        $('#formTransaction').submit(function(e) {
            if ($('#status').val() == 'selesai') {
                var paid = parseFloat($('#money_paid').val()) || 0;
                var dpValue = {{ $transaction->dp ?? 0 }};
                var sisaBayar = grandTotalValue - dpValue;
                if(sisaBayar < 0) sisaBayar = 0;
                if (paid < sisaBayar) {
                    e.preventDefault();
                    Swal.fire('Uang Kurang!', 'Uang bayar (Rp '+paid.toLocaleString('id-ID')+') kurang dari tagihan Sisa Bayar (Rp '+sisaBayar.toLocaleString('id-ID')+')', 'error');
                }
            }
        });
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                customClass: { confirmButton: 'btn btn-primary' },
                buttonsStyling: false
            });
        @endif
    });
</script>
@endpush
