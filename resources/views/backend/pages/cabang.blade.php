@extends('backend.layouts.index')

@section('konten')
    Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Manajemen Cabang</h4>
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
                                            <form id="formcabang" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode Cabang</label>
                                                    <input type="text" class="form-control" name="kode_cabang"
                                                        id="exampleFormControlInput1" placeholder="masukkan Kode Cabang">
                                                </div> --}}

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Alamat</label>
                                                    <textarea class="form-control" name="alamat" placeholder="masukkan alamat"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Apakah Pusat?</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="is_pusat"
                                                            value="1" id="is_pusat">
                                                        <label class="form-check-label" for="is_pusat">
                                                            Ya, ini cabang pusat
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="btnSaveCabang">Save
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
                                            <th>Kode Cabang</th>
                                            <th>Alamat</th>
                                            <th>Pusat</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cabang as $key => $cabang)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $cabang->prefix . str_pad($cabang->number, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                                <td>{{ $cabang->alamat }}</td>
                                                <td>
                                                    @if ($cabang->is_pusat == 1)
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            class="text-success" height="16" fill="currentColor"
                                                            class="bi bi-check-square-fill " viewBox="0 0 16 16">
                                                            <path
                                                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z" />
                                                        </svg>
                                                    @endif
                                                <td>
                                                    {{-- edit  --}}
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#Edit-{{ $cabang->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-pencil-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                        </svg>
                                                    </button>
                                                    {{-- modal edit --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Edit-{{ $cabang->id }}"
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
                                                                <form class="editformcabang" data-id="{{ $cabang->id }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        {{-- <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Kode
                                                                                Cabang</label>
                                                                            <input type="text" class="form-control"
                                                                                name="kode_cabang"
                                                                                id="exampleFormControlInput1"
                                                                                value="{{ $cabang->kode_cabang }}">
                                                                        </div> --}}
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="exampleFormControlInput1">Alamat</label>
                                                                            <textarea class="form-control" name="alamat" placeholder="masukkan cabang">{{ strip_tags($cabang->alamat) }}</textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Apakah Pusat?</label>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="is_pusat"
                                                                                    value="1" id="is_pusat"
                                                                                    {{ $cabang->is_pusat == 1 ? 'checked' : '' }}>

                                                                                <label class="form-check-label"
                                                                                    for="is_pusat">
                                                                                    Ya, ini cabang pusat
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- akhir modal edit --}}
                                                    {{-- akhir edit --}}

                                                    {{-- delete --}}
                                                    <form action="{{ route('Cabang.destroy', $cabang->id) }}"
                                                        method="POST" class="form-delete-cabang mt-3">
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
        $('#btnSaveCabang').on('click', function() {
            let form = document.getElementById('formcabang');
            let formData = new FormData(form);


            $.ajax({
                url: "{{ route('Tambah_Cabang') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('#btnSaveCabang')
                        .prop('disabled', true)
                        .text('Menyimpan...');
                },

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Cabang berhasil ditambahkan',
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
                    $('#btnSaveCabang')
                        .prop('disabled', false)
                        .text('Simpan Cabang');
                }
            });
        });

        // edit
        $(document).on('submit', '.editformcabang', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_cabang') }}/" + id,
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
        $(document).on('submit', '.form-delete-cabang', function(e) {
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
