@extends('backend.layouts.index')

@section('konten')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Tambah Internal Delivery</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <form id="forminternaldelivery"> @csrf
                <div class="row page-titles mx-0">
                    <div class="col-sm-3 p-md-0 mr-3">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Date Transaction</label>
                            <input type="date" class="form-control" id="birthday" name="date_transaction">
                        </div>

                    </div>
                    <div class="col-sm-3 p-md-0 mr-3">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Warehouse From</label>

                            <select id="warehouse_from" name = "warehouse_from" class="form-control select2">
                                <option value="" selected disabled>Choose Warehouse...</option>
                                @foreach ($warehouse as $warehouses)
                                    <option value=" {{ $warehouses->id }}">
                                        {{ $warehouses->warehouse_name }} </option>
                                @endforeach

                            </select>

                        </div>

                    </div>
                    <div class="col-sm-3 p-md-0 mr-3">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Warehouse To</label>
                            <select id="warehouse_to" name = "warehouse_to" class="form-control select2">
                                <option selected disabled>Choose...</option>
                                @foreach ($warehousess as $warehousesz)
                                    <option value=" {{ $warehousesz->id }}">
                                        {{ $warehousesz->warehouse_name }} </option>
                                @endforeach

                            </select>

                        </div>

                    </div>
                    <div class="col-sm-6 p-md-0 mr-3">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Remarks</label>
                            <textarea name = "remark" class="form-control" id="" rows="3"></textarea>

                        </div>

                    </div>

                </div>

                <div class="row page-titles mx-0 table-responsive">
                    <table id="" class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>QTY</th>
                                <th>Remark</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="itemTableBody">
                            <tr>
                                <td class="row-number">1</td>

                                <td>
                                    <select name="item_id[]" class="form-control select3 item-select">
                                        <option value="">-- Pilih Item --</option>
                                    </select>
                                    {{-- <select name="item_id[]" class="form-control select3 item-select">
                                    <option value="">-- Pilih Item --</option>

                                    @foreach ($product as $productss)
                                        <option value="{{ $productss->id }}" data-unit-id="{{ $productss->unit_id }}"
                                            data-unit-name="{{ $productss->unit->name_unit }}"
                                            data-small-unit-id="{{ $productss->small_unit_id }}"
                                            data-small-unit-name="{{ $productss->small_unit->name_unit }}">
                                            {{ $productss->sku_code }} - {{ $productss->nama_item }}
                                        </option>
                                    @endforeach
                                </select> --}}

                                </td>

                                <td>
                                    <select name="unit_id[]" class="form-control unit-select">
                                        <option value="">-- Pilih Unit --</option>
                                    </select>

                                </td>

                                <td>
                                    <input type="number" name="qty[]" class="form-control qty-input" placeholder="QTY"
                                        min="1" step="any">

                                    <small class="text-danger qty-error" style="display: none;">
                                    </small>
                                </td>

                                <td>
                                    <textarea name="remarkd[]" class="form-control" placeholder="Remark" rows="3"></textarea>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-remove">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" id="btnAddRow" class="btn btn-primary">
                                + Tambah Item
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success w-50 float-right" id="btnSaveInternalDelivery">
                                Simpan
                            </button>
                        </div>
                    </div>



                </div>
            </form> {{-- FORM SELESAI --}}
        </div>
    </div>

    <script>
        // select item 
        let warehouseItems = [];
        $(document).ready(function() {

            // Menyimpan data item dari warehouse yang dipilih

            // Ketika Warehouse From berubah
            $('#warehouse_from').on('change', function() {
                let warehouseId = $(this).val();
                // Kosongkan semua item select
                $('.item-select').html(
                    '<option value="">-- Pilih Item --</option>'
                );

                // Kosongkan data item sebelumnya
                warehouseItems = [];

                // Jika warehouse belum dipilih
                if (!warehouseId) {
                    return;
                }

                $.ajax({

                    url: "{{ url('/internal-delivery/items') }}/" + warehouseId,

                    type: "GET",

                    dataType: "json",

                    success: function(data) {
                        // Simpan hasil AJAX ke warehouseItems
                        warehouseItems = data;
                        // Update semua dropdown item
                        updateAllItemSelect();
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        alert('Gagal mengambil data item dari warehouse.');

                    }

                });

            });


            // Fungsi untuk mengisi semua dropdown item
            function updateAllItemSelect() {

                $('.item-select').each(function() {

                    let select = $(this);

                    select.empty();

                    select.append(
                        '<option value="">-- Pilih Item --</option>'
                    );

                    $.each(warehouseItems, function(index, inventory) {

                        if (!inventory.item) {
                            return;
                        }

                        let item = inventory.item;

                        select.append(`
                <option
                    value="${item.id}"
                    data-unit-id="${item.unit_id ?? ''}"
                    data-inventory-id="${inventory.id}"
                    data-ratio="${item.ratio_unit}"
                    data-stock="${inventory.stok}"   
                    data-unit-name="${item.unit ? item.unit.name_unit : ''}"
                    data-small-unit-id="${item.small_unit_id ?? ''}"
                    data-small-unit-name="${item.small_unit ? item.small_unit.name_unit : ''}">

                    ${item.sku_code} - ${item.nama_item}

                </option>
            `);

                    });

                });

            }

        });

        // akhir select item
        $(document).ready(function() {

            console.log('SCRIPT UNIT DIMUAT');

            $(document).on('change', '.item-select', function() {

                console.log('========== ITEM DIPILIH ==========');

                let itemId = $(this).val();
                console.log('Item ID:', itemId);
                let selectedOption = $(this).find('option:selected');
                console.log('Selected Option:', selectedOption);
                let unitId = selectedOption.attr('data-unit-id');
                let smallUnitId = selectedOption.attr('data-small-unit-id');
                let unitName = selectedOption.attr('data-unit-name');
                let smallUnitName = selectedOption.attr('data-small-unit-name');
                let inv_id = selectedOption.attr('data-inventory-id');
                let Stok = selectedOption.attr('data-stock');
                let Ratio = selectedOption.attr('data-ratio');
                // console.log('Unit ID:', unitId);
                // console.log('Small Unit ID:', smallUnitId);

                let unitSelect = $(this)
                    .closest('tr')
                    .find('.unit-select');

                console.log('Jumlah Unit Select:', unitSelect.length);

                unitSelect.empty();

                unitSelect.append(
                    '<option value="">-- Pilih Unit --</option>'
                );

                if (unitId) {
                    unitSelect.append(
                        `<option value="${unitId}">${unitName}</option>`
                    );
                }

                if (smallUnitId && smallUnitId != unitId) {
                    unitSelect.append(
                        `<option value="${smallUnitId}"> ${smallUnitName}</option>`
                    );
                }
            });
        });
        // multiple input
        $(document).ready(function() {
            // =========================
            // TAMBAH ROW
            // =========================
            $('#btnAddRow').click(function() {
                let row = `
            <tr>

                    <td class="row-number"></td>

                    <td>
                        <select
                        name="item_id[]"
                        class="form-control select3 item-select">

                        <option value="">
                            -- Pilih Item --
                        </option>

                    </select>
                    </td>

                    <td>
                        <select
                            name="unit_id[]"
                            class="form-control unit-select">

                            <option value="">
                                -- Pilih Unit --
                            </option>

                        </select>
                    </td>

                    <td>
                         <input
                            type="number"
                            name="qty[]"
                            class="form-control qty-input"
                            placeholder="QTY"
                            min="1"
                            step="any">
                        <small
                            class="qty-error text-danger"
                            style="display: none;">
                        </small>
                    </td>

                <td>
                    <textarea
                        name="remarkd[]"
                        class="form-control"
                        placeholder="Remark"
                        rows="3"></textarea>
                </td>

                    <td>
                        <button
                            type="button"
                            class="btn btn-danger btn-sm btn-remove">
                            Hapus
                        </button>
                    </td>

                </tr>
            `;

                // Tambahkan row
                $('#itemTableBody').append(row);

                // Ambil row terakhir
                let lastRow = $('#itemTableBody tr:last');
                let select = lastRow.find('.item-select');
                // Ambil item hasil getItemsByWarehouse
                $.each(warehouseItems, function(index, inventory) {

                    if (!inventory.item) {
                        return;
                    }

                    let item = inventory.item;

                    select.append(`
            <option
                value="${item.id}"
                data-inventory-id="${inventory.id}"
                data-stock="${inventory.stok}" 
                data-unit-id="${item.unit_id ?? ''}"
                 data-ratio="${item.ratio_unit}"
                data-unit-name="${item.unit ? item.unit.name_unit : ''}"
                data-small-unit-id="${item.small_unit_id ?? ''}"
                data-small-unit-name="${item.small_unit ? item.small_unit.name_unit : ''}">
                
                ${item.sku_code} - ${item.nama_item}

            </option>
        `);

                });

                // Aktifkan Select2 pada row baru
                lastRow.find('.select3').select2({
                    placeholder: 'Choose Item',
                    allowClear: true,
                    width: '100%'
                });

                // Update nomor
                updateRowNumber();
            });
            // =========================
            // HAPUS ROW
            // =========================

            $(document).on('click', '.btn-remove', function() {

                if ($('#itemTableBody tr').length > 1) {

                    $(this)
                        .closest('tr')
                        .remove();

                    updateRowNumber();

                } else {
                    alert('Minimal harus ada 1 item.');

                }

            });
            // =========================
            // UPDATE NOMOR
            // =========================

            function updateRowNumber() {

                $('#itemTableBody tr').each(function(index) {

                    $(this)
                        .find('.row-number')
                        .text(index + 1);
                });
            }
        });

        function validateQty(row) {

            let qtyInput = row.find('.qty-input');

            let itemSelect = row.find('.item-select');

            let unitSelect = row.find('.unit-select');

            let selectedOption = itemSelect.find('option:selected');

            let selectedUnitId = unitSelect.val();
            let namaselectedUnit = unitSelect
                .find('option:selected')
                .text()
                .trim();

            let unitId = selectedOption.attr('data-unit-id');

            let smallUnitId = selectedOption.attr('data-small-unit-id');

            let originalStock = parseFloat(
                selectedOption.attr('data-stock')
            ) || 0;

            let ratio = parseFloat(
                selectedOption.attr('data-ratio')
            ) || 1;

            let qty = parseFloat(
                qtyInput.val()
            ) || 0;

            let stock = originalStock;

            // Jika menggunakan Small Unit
            if (
                selectedUnitId &&
                selectedUnitId == smallUnitId
            ) {
                stock = originalStock * ratio;
            }

            let errorMessage = row.find('.qty-error');

            console.log('Stok asli:', originalStock);
            console.log('Ratio:', ratio);
            console.log('Nama Unit:', namaselectedUnit);
            console.log('Unit:', selectedUnitId);
            console.log('Stok tersedia:', stock);
            console.log('QTY:', qty);

            if (qty > stock) {

                errorMessage
                    .text(
                        'QTY melebihi stok tersedia. Stok: ' + stock +
                        ' ' +
                        namaselectedUnit
                    )
                    .show();

                qtyInput.addClass('is-invalid');

            } else {

                errorMessage
                    .text('')
                    .hide();

                qtyInput.removeClass('is-invalid');

            }
        }
        $(document).on('change', '.unit-select', function() {

            validateQty(
                $(this).closest('tr')
            );

        });
        // $(document).on('input', '.qty-input', function() {


        //     let qtyInput = $(this);
        //     // Ambil baris yang sama
        //     let row = qtyInput.closest('tr');
        //     // Cari select item pada baris yang sama
        //     let itemSelect = row.find('.item-select');
        //     // Ambil option yang sedang dipilih
        //     let selectedOption = itemSelect.find('option:selected');

        //     // Ambil unit yang dipilih
        //     let unitSelect = row.find('.unit-select');

        //     let selectedUnitId = unitSelect.val();
        //     // Data item
        //     let unitId = selectedOption.attr('data-unit-id');
        //     let smallUnitId = selectedOption.attr('data-small-unit-id');


        //     console.log('ROW:', row);
        //     console.log('ITEM SELECT wadidaw:', itemSelect);
        //     console.log('SELECTED OPTION:', selectedOption);
        //     console.log('ITEM ID:', itemSelect.val());
        //     console.log('STOCK:', selectedOption.attr('data-stock'));
        //     // Ambil stok dari data-stock
        //     let stock = parseFloat(
        //         selectedOption.attr('data-stock')
        //     );

        //     validateQty(
        //         $(this).closest('tr')
        //     );

        //     // Ambil QTY yang sedang diketik
        //     let qty = parseFloat(qtyInput.val()) || 0;

        //     // Cari elemen pesan error
        //     let errorMessage = row.find('.qty-error');

        //     // Jika QTY melebihi stok
        //     if (qty > stock) {

        //         errorMessage
        //             .text('QTY melebihi stok tersedia. Stok: ' + stock)
        //             .show();

        //         qtyInput.addClass('is-invalid');

        //     } else {

        //         errorMessage
        //             .text('')
        //             .hide();

        //         qtyInput.removeClass('is-invalid');

        //     }

        // });
        $(document).on('input', '.qty-input', function() {

            let qtyInput = $(this);

            // Ambil row yang sama
            let row = qtyInput.closest('tr');

            // Ambil item
            let itemSelect = row.find('.item-select');

            // Ambil item yang dipilih
            let selectedOption = itemSelect.find('option:selected');

            // Ambil unit yang dipilih
            let unitSelect = row.find('.unit-select');

            let selectedUnitId = unitSelect.val();

            // Data item
            let unitId = selectedOption.attr('data-unit-id');
            let smallUnitId = selectedOption.attr('data-small-unit-id');

            // Stok asli dari Inventory Manage
            let originalStock = parseFloat(
                selectedOption.attr('data-stock')
            ) || 0;

            // Ratio konversi
            let ratio = parseFloat(
                selectedOption.attr('data-ratio')
            ) || 1;

            // QTY yang diketik
            let qty = parseFloat(
                qtyInput.val()
            ) || 0;

            // =========================
            // HITUNG STOK BERDASARKAN UNIT
            // =========================

            let stock = originalStock;

            // Jika pilih Small Unit
            if (
                selectedUnitId &&
                smallUnitId &&
                selectedUnitId == smallUnitId
            ) {
                stock = originalStock * ratio;
            }
            let namaselectedUnit = unitSelect
                .find('option:selected')
                .text()
                .trim();
            let errorMessage = row.find('.qty-error');
            console.log('======================');
            console.log('Item ID:', itemSelect.val());
            console.log('Unit ID:', selectedUnitId);
            console.log('Main Unit ID:', unitId);
            console.log('Small Unit ID:', smallUnitId);
            console.log('Stok Asli:', originalStock);
            console.log('Ratio:', ratio);
            console.log('Stok Setelah Konversi:', stock);
            console.log('QTY:', qty);

            // =========================
            // VALIDASI
            // =========================



            if (qty > stock) {

                errorMessage
                    .text(
                        'QTY melebihi stok tersedia. Stok: ' +
                        stock +
                        ' ' +
                        namaselectedUnit
                    )
                    .show();

                qtyInput.addClass('is-invalid');

            } else {

                errorMessage
                    .text('')
                    .hide();

                qtyInput.removeClass('is-invalid');

            }
            validateQty(row);
        });


        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Choose Warehouse',
                allowClear: true,
                width: '100%'
            });
            $('.select3').select2({
                placeholder: 'Choose Item',
                allowClear: true,
                width: '100%'
            });
        });

        $('#forminternaldelivery').on('submit', function(e) {

            // Mencegah submit HTML bawaan
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('Tambah_InternalDelivery') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {

                    $('#btnSaveInternalDelivery')
                        .prop('disabled', true)
                        .text('Menyimpan...');

                },

                success: function(res) {

                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Internal Delivery berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                },

                error: function(xhr) {

                    console.log('STATUS:', xhr.status);
                    console.log('RESPONSE:', xhr.responseText);

                    let pesan = 'Terjadi kesalahan';

                    if (xhr.status === 422 && xhr.responseJSON.errors) {

                        let errors = xhr.responseJSON.errors;

                        pesan = '';

                        for (let key in errors) {
                            pesan += `• ${errors[key][0]}<br>`;
                        }

                    } else if (xhr.responseJSON && xhr.responseJSON.message) {

                        pesan = xhr.responseJSON.message;

                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: pesan
                    });

                },

                complete: function() {

                    $('#btnSaveInternalDelivery')
                        .prop('disabled', false)
                        .text('Simpan');

                }

            });

        });
    </script>
    <!--**********************************!>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Content body end
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ***********************************-->
@endsection
