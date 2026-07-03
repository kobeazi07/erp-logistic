@extends('backend.layouts.index')

@section('konten')
    Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Manajemen prefix</h4>
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

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode prefix</th>
                                            <th>Nama prefix</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prefix as $key => $prefix)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $prefix->prefix }}</td>
                                                <td>{{ $prefix->next_number }}</td>
                                                <td>
                                                    @if ($prefix->type == 1)
                                                        Cabang
                                                    @elseif($prefix->type == 2)
                                                        Jabatan
                                                    @elseif($prefix->type == 3)
                                                        Brand
                                                    @elseif($prefix->type == 4)
                                                        Kategori
                                                    @elseif($prefix->type == 5)
                                                        Items
                                                    @elseif($prefix->type == 6)
                                                        vVendor
                                                    @else
                                                        Tidak Diketahui
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- edit  --}}
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#Edit-{{ $prefix->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-pencil-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                        </svg>
                                                    </button>
                                                    {{-- modal edit --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Edit-{{ $prefix->id }}"
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
                                                                <form class="editformprefix" data-id="{{ $prefix->id }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Kode
                                                                                prefix</label>
                                                                            <input type="text" class="form-control"
                                                                                name="prefix" id="exampleFormControlInput1"
                                                                                value="{{ $prefix->prefix }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Next
                                                                                Number</label>
                                                                            <input type="number" class="form-control"
                                                                                name="next_number"
                                                                                id="exampleFormControlInput1"
                                                                                value="{{ $prefix->next_number }}">
                                                                            <input type="hidden" class="form-control"
                                                                                name="type" id="exampleFormControlInput1"
                                                                                value="{{ $prefix->type }}">

                                                                        </div>
                                                                        <div class="form-group"><label class="fw-bold"
                                                                                for="exampleFormControlInput1"> Type Prefix
                                                                            </label>
                                                                            <h4>
                                                                                @if ($prefix->type == 1)
                                                                                    Cabang
                                                                                @elseif($prefix->type == 2)
                                                                                    Jabatan
                                                                                @elseif($prefix->type == 3)
                                                                                    Brand
                                                                                @elseif($prefix->type == 4)
                                                                                    Kategori
                                                                                @elseif($prefix->type == 5)
                                                                                    Items
                                                                                @elseif($prefix->type == 6)
                                                                                    Vendor
                                                                                @else
                                                                                    Tidak Diketahui
                                                                                @endif
                                                                            </h4>

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
        // edit
        $(document).on('submit', '.editformprefix', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_prefix') }}/" + id,
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
    </script>
    <!--**********************************!>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Content body end
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ***********************************-->
@endsection
