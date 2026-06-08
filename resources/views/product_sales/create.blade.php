@extends('layouts.app')
@section('title', 'Transaksi Penjualan Baru')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0">POS Penjualan Langsung</h5>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger mx-4 mt-4">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mx-4 mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('product-sales.store') }}" method="POST" id="formSale">
                    @csrf
                    <div class="card-body mt-3">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelanggan (Opsional)</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Umum">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. WhatsApp (Opsional)</label>
                                <input type="text" class="form-control" name="customer_phone" placeholder="08...">
                            </div>
                        </div>

                        <h6 class="mb-3"><i class="ti ti-package"></i> Daftar Produk / Sparepart</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered" id="sparepartsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pilih Produk</th>
                                        <th style="width: 150px;">Qty</th>
                                        <th style="width: 200px;">Harga Satuan</th>
                                        <th style="width: 200px;">Subtotal</th>
                                        <th style="width: 80px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="sparepartsBody">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddSparepart">
                                                <i class="ti ti-plus me-1"></i> Tambah Produk
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="p-4 bg-label-success rounded mb-4">
                            <h6><i class="ti ti-cash"></i> Pembayaran Kasir</h6>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-6">
                                    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded border border-success">
                                        <h5 class="mb-0 text-success">TOTAL TAGIHAN</h5>
                                        <h3 class="mb-0 text-success fw-bold">Rp <span id="lblGrandTotal">0</span></h3>
                                        <input type="hidden" id="grand_total_input" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-success">Metode Pembayaran</label>
                                    <select name="payment_method" id="payment_method" class="form-select border-success">
                                        <option value="cash">Cash / Tunai</option>
                                        <option value="qris">QRIS / Transfer</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-success">Uang Bayar (Rp)</label>
                                    <input type="number" id="money_paid" name="money_paid" class="form-control form-control-lg border-success" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-success">Kembalian (Rp)</label>
                                    <input type="text" id="money_change" class="form-control form-control-lg bg-transparent border-0 text-success fw-bold" readonly value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top text-end pt-4 bg-lighter">
                        <a href="{{ route('product-sales.index') }}" class="btn btn-label-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSave"><i class="ti ti-device-floppy me-1"></i> Proses Penjualan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            var sparepartOptions = '<option value="">-- Pilih Produk --</option>';
            @foreach($spareparts as $s)
                sparepartOptions += '<option value="{{ $s->id }}" data-price="{{ $s->selling_price }}" data-stock="{{ $s->stock_sparepart }}">{{ $s->name_sparepart }} (Stok: {{ $s->stock_sparepart }}) - Rp {{ number_format($s->selling_price, 0, ",", ".") }}</option>';
            @endforeach
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
            function unformatRupiah(string) {
                if(!string) return 0;
                return parseInt(string.replace(/[^,\d]/g, '').toString()) || 0;
            }
            function calculateTotals() {
                var grandTotal = 0;
                $('.sparepart-subtotal').each(function() {
                    grandTotal += unformatRupiah($(this).val());
                });
                $('#lblGrandTotal').text(formatRupiah(grandTotal));
                $('#grand_total_input').val(grandTotal);

                if ($('#payment_method').val() == 'qris') {
                    $('#money_paid').val(grandTotal);
                }
                calcChange(grandTotal);
            }
            function calcChange(totalBill) {
                var paid = parseFloat($('#money_paid').val()) || 0;
                var change = paid - totalBill;
                if (change < 0) {
                    $('#money_change').val('0');
                } else {
                    $('#money_change').val(formatRupiah(change));
                }
            }

            $('#btnAddSparepart').click(function() {
                var tr = `
                    <tr>
                        <td>
                            <select name="spareparts[]" class="form-select select2-sparepart" required>
                                ${sparepartOptions}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantities[]" class="form-control qty-input" value="1" min="1" required>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control price-input" readonly value="0">
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control sparepart-subtotal bg-label-secondary" readonly value="0">
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-danger btn-remove-row"><i class="ti ti-trash"></i></button>
                        </td>
                    </tr>
                `;
                $('#sparepartsBody').append(tr);

                $('#sparepartsBody').find('.select2-sparepart').last().select2({
                    placeholder: '-- Pilih Produk --',
                    allowClear: true
                });
            });

            $(document).on('click', '.btn-remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $(document).on('change', '.select2-sparepart', function() {
                var selectedOpt = $(this).find('option:selected');
                var price = selectedOpt.data('price') || 0;
                var maxStock = selectedOpt.data('stock') || 0;
                var tr = $(this).closest('tr');
                tr.find('.price-input').val(formatRupiah(price));
                var qtyInput = tr.find('.qty-input');
                qtyInput.attr('max', maxStock);
                var qty = qtyInput.val();
                if(qty > maxStock) {
                    qtyInput.val(maxStock);
                    qty = maxStock;
                    Swal.fire('Stok Terbatas', 'Stok produk ini hanya tersisa ' + maxStock, 'warning');
                }
                var subtotal = price * qty;
                tr.find('.sparepart-subtotal').val(formatRupiah(subtotal));
                calculateTotals();
            });

            $(document).on('input', '.qty-input', function() {
                var tr = $(this).closest('tr');
                var selectedOpt = tr.find('.select2-sparepart option:selected');
                var price = selectedOpt.data('price') || 0;
                var maxStock = selectedOpt.data('stock') || 0;
                var qty = $(this).val();
                if(qty > maxStock && maxStock > 0) {
                    $(this).val(maxStock);
                    qty = maxStock;
                    Swal.fire('Stok Terbatas', 'Stok produk ini hanya tersisa ' + maxStock, 'warning');
                }
                var subtotal = price * qty;
                tr.find('.sparepart-subtotal').val(formatRupiah(subtotal));
                calculateTotals();
            });

            $('#payment_method').on('change', function() {
                var method = $(this).val();
                var total = parseFloat($('#grand_total_input').val()) || 0;
                if (method == 'qris') {
                    $('#money_paid').val(total);
                    $('#money_paid').prop('readonly', true);
                } else {
                    $('#money_paid').val('');
                    $('#money_paid').prop('readonly', false);
                }
                calcChange(total);
            });

            $('#money_paid').on('input', function() {
                var total = parseFloat($('#grand_total_input').val()) || 0;
                calcChange(total);
            });

            $('#formSale').on('submit', function(e) {
                var total = parseFloat($('#grand_total_input').val()) || 0;
                var paid = parseFloat($('#money_paid').val()) || 0;
                if ($('.select2-sparepart').length === 0) {
                    e.preventDefault();
                    Swal.fire('Peringatan', 'Mohon tambahkan minimal 1 produk', 'warning');
                    return false;
                }
                if (paid < total) {
                    e.preventDefault();
                    Swal.fire('Peringatan', 'Uang bayar (Rp ' + formatRupiah(paid) + ') kurang dari total tagihan (Rp ' + formatRupiah(total) + ')', 'warning');
                    return false;
                }
            });

            $('#btnAddSparepart').click();
        })
    </script>
@endpush
