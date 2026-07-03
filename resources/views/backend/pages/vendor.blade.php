@extends('backend.layouts.index')

@section('konten')
    Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Manajemen Supplier</h4>
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


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="display:block !important;">
                            {{-- modal tambah --}}
                            <!-- Large modal -->
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target=".bd-example-modal-lg">Tambah + </button>
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formvendor" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode Supplier</label>
                                                    <input type="text" class="form-control" name="kode_vendor"
                                                        id="exampleFormControlInput1" placeholder="masukkan Kode Supplier">
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Supplier</label>
                                                    <input type="text" class="form-control" name="name_vendor"
                                                        id="exampleFormControlInput1" placeholder="masukkan nama Supplier">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="btnSaveVendor">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- akhir modal tambah --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Supllier</th>
                                            <th>Nama Supplier</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vendor as $key => $vendor)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $vendor->prefix . str_pad($vendor->number, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>{{ $vendor->name_vendor }}</td>
                                                <td>
                                                    {{-- edit  --}}
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#Edit-{{ $vendor->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-pencil-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                        </svg>
                                                    </button>
                                                    {{-- modal edit --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Edit-{{ $vendor->id }}"
                                                        data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">Modal
                                                                        title</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form class="editformvendor" data-id="{{ $vendor->id }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        {{-- <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Kode
                                                                                Supplier</label>
                                                                            <input type="text" class="form-control"
                                                                                name="kode_vendor"
                                                                                id="exampleFormControlInput1"
                                                                                value="{{ $vendor->kode_vendor }}">
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Nama
                                                                                Supplier</label>
                                                                            <input type="text" class="form-control"
                                                                                name="name_vendor"
                                                                                id="exampleFormControlInput1"
                                                                                value="{{ $vendor->name_vendor }}">

                                                                        </div>



                                                                        <div class="row">

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- akhir modal edit --}}
                                                    {{-- akhir edit --}}

                                                    {{-- delete --}}
                                                    <form action="{{ route('Vendor.destroy', $vendor->id) }}"
                                                        method="POST" class="form-delete-vendor mt-3">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-submit-delete"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    {{-- akhir delete --}}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('#btnSaveVendor').on('click', function() {
            let form = document.getElementById('formvendor');
            let formData = new FormData(form);


            $.ajax({
                url: "{{ route('Tambah_Vendor') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('#btnSaveVendor')
                        .prop('disabled', true)
                        .text('Menyimpan...');
                },

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Vendor berhasil ditambahkan',
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
                    $('#btnSaveVendor')
                        .prop('disabled', false)
                        .text('Simpan Vendor');
                }
            });
        });

        // edit
        $(document).on('submit', '.editformvendor', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_vendor') }}/" + id,
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
        $(document).on('submit', '.form-delete-vendor', function(e) {
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
