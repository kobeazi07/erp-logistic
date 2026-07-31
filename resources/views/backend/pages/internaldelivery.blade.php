@extends('backend.layouts.index')

@section('konten')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Manajemen warehouse</h4>
                        <span class="ml-1">Datatable</span>
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
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card-header" style="display:block !important;">
                        <a href="{{ route('HalamanTInternalDelivery') }}">

                            <button type="button" class="btn btn-primary float-right">Tambah + </button>
                        </a>


                    </div>
                </div>


            </div>

            <div class="row">

                <!-- Tabel -->
                <div class="col-md-12" id="tableColumn">
                    <div class="card">

                        <div class="card-body">
                            <button class="btn btn-primary mb-3 float-right" id="btnToggleDetail">
                                Tampilkan Detail << </button>
                                    <table class="table table-bordered" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Warehouse From</th>
                                                <th>Warehouse To</th>
                                                <th>Date Transaction</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($internaldelivery as $key => $row)
                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ $row->prefix }}{{ str_pad($row->number, 4, '0', STR_PAD_LEFT) }}
                                                    </td>

                                                    <td>{{ $row->warehouseFrom->warehouse_name }}</td>
                                                    <td>{{ $row->warehouseTo->warehouse_name }}</td>
                                                    <td>{{ $row->date_transaction }}</td>
                                                    <td>{{ $row->status }}</td>
                                                    <td>{{ $row->User->name }}</td>
                                                    <td>

                                                        <button class="btn btn-success btn-detail" data-bs-toggle="collapse"
                                                            data-bs-target="#detailCollapse" data-id="{{ $row->id }}">
                                                            Detail
                                                        </button>

                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                        </div>
                    </div>
                </div>

                <!-- Detail -->
                <div class="col-md-4 collapse" id="detailCollapse">

                    <div class="collapse" id="detailCollapse">

                        <div class="card">

                            <div class="card-header">
                                Detail Internal Delivery
                            </div>

                            <div class="card-body" id="detailContent">

                                Silakan pilih data.

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        //detail collapse
        let detailVisible = false;

        $('#btnToggleDetail').click(function() {

            if (!detailVisible) {

                // tampilkan detail
                $('#tableColumn')
                    .removeClass('col-md-12')
                    .addClass('col-md-8');

                $('#detailCollapse').collapse('show');

                $(this).html('Tutup Detail >>');

                detailVisible = true;

            } else {

                // sembunyikan detail
                $('#detailCollapse').collapse('hide');

                $('#tableColumn')
                    .removeClass('col-md-8')
                    .addClass('col-md-12');

                $(this).html('Tampilkan Detail <<');

                detailVisible = false;

            }

        });
        $(document).on('click', '.btn-detail', function() {

            let id = $(this).data('id');

            $.ajax({

                url: '/internal-delivery/detail/' + id,
                type: 'GET',

                success: function(res) {

                    let html = `
                <table class="table table-sm">

                    <tr>
                        <th>No Delivery</th>
                        <td>${res.prefix}${String(res.number).padStart(4,'0')}</td>
                    </tr>

                    <tr>
                        <th>Dari</th>
                        <td>${res.warehouse_from.warehouse_name}</td>
                    </tr>

                    <tr>
                        <th>Tujuan</th>
                        <td>${res.warehouse_to.warehouse_name}</td>
                    </tr>

                </table>

                <hr>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                        </tr>
                    </thead>

                    <tbody>
            `;

                    res.details.forEach(function(item) {

                        html += `
                    <tr>
                        <td>${item.item.nama_barang}</td>
                        <td>${item.qty}</td>
                    </tr>
                `;

                    });

                    html += `
                    </tbody>
                </table>
            `;

                    $('#detailContent').html(html);

                }

            });

        });
        $('#btnSavewarehouse').on('click', function() {
            let form = document.getElementById('formwarehouse');
            let formData = new FormData(form);


            $.ajax({
                url: "{{ route('Tambah_Warehouse') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('#btnSavewarehouse')
                        .prop('disabled', true)
                        .text('Menyimpan...');
                },

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'warehouse berhasil ditambahkan',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },

                error: function(xhr) {
                    let pesan = 'Terjadi kesalahan';

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        pesan = '';
                        for (let key in errors) {
                            pesan += `• ${errors[key][0]}<br>`;
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: pesan
                    });
                },

                complete: function() {
                    $('#btnSavewarehouse')
                        .prop('disabled', false)
                        .text('Simpan warehouse');
                }
            });
        });

        // edit
        $(document).on('submit', '.editformwarehouse', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_warehouse') }}/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Sukses', response.message, 'success');
                    $('#Edit-' + id).modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });

        // delete
        $(document).on('submit', '.form-delete-warehouse', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');

            console.log('DELETE URL:', url);

            Swal.fire({
                title: 'Yakin?',
                text: 'Data akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: form.serialize(), // sudah ada _method=DELETE + _token
                        success: function(response) {
                            Swal.fire('Terhapus!', response.message, 'success')
                                .then(() => location.reload());
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            Swal.fire('Error', 'Gagal menghapus data', 'error');
                        }
                    });

                }
            });
        });
    </script>
    <!--**********************************!>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Content body end
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ***********************************-->
@endsection
