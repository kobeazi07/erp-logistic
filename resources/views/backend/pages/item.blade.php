@extends('backend.layouts.index')

@section('konten')
    Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Manajemen Item</h4>
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
                                            <form id="formitem" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Kode SKU</label>
                                                    <input type="text" class="form-control" name="kode_sku"
                                                        id="exampleFormControlInput1" placeholder="masukkan Kode Items">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Nama Item</label>
                                                    <input type="text" class="form-control" name="nama_item"
                                                        id="exampleFormControlInput1" placeholder="masukkan nama Items">
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label>Kategori</label>
                                                        <select id="id_kat_program" name = "kategori_id"
                                                            class="form-control">
                                                            <option selected disabled riquired>Choose...</option>
                                                            @foreach ($kategori as $kat)
                                                                <option value=" {{ $kat->id }}">
                                                                    {{ $kat->name_kategori }} </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6  ">
                                                        <label>Brand</label>
                                                        <select id="id_kat_program" name = "brand_id" class="form-control">
                                                            <option selected disabled riquired>Choose...</option>
                                                            @foreach ($brand as $brand)
                                                                <option value=" {{ $brand->id }}">
                                                                    {{ $brand->name_brand }} </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 ">
                                                        <label>Unit</label>
                                                        <select id="id_kat_program" name = "unit_id" class="form-control">
                                                            <option selected disabled riquired>Choose...</option>
                                                            @foreach ($unit as $unit)
                                                                <option value=" {{ $unit->id }}">
                                                                    {{ $unit->name_unit }} </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 ">
                                                        <label>Small Unit</label>
                                                        <select id="id_kat_program" name = "small_unit_id"
                                                            class="form-control">
                                                            <option selected disabled riquired>Choose...</option>
                                                            @foreach ($s_unit as $s_unit)
                                                                <option value=" {{ $s_unit->id }}">
                                                                    {{ $s_unit->name_unit }} </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="exampleFormControlInput1">Ratio Unit</label>
                                                        <input type="text" class="form-control" name="ratio_unit"
                                                            id="exampleFormControlInput1" placeholder="masukkan Ratio Unit">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="exampleFormControlInput1">Thumbnail</label>
                                                        <div class="input-group ">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input name ="thumbnail" type="file"
                                                                    class="custom-file-input">
                                                                <label class="custom-file-label">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="exampleFormControlInput1">Deskripsi</label>
                                                        <textarea name = "deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Detail Gambar</label>
                                                        <div class="input-group mb-3">
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="addInput()">Tambah
                                                                +</button>

                                                        </div>
                                                        <div id = "items-container"></div>
                                                    </div>
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" id="btnSaveItem">Save
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
                                            <th>Kode SKU</th>
                                            <th>Nama Item</th>
                                            <th>Kategori</th>
                                            <th>Brand</th>
                                            <th>Unit</th>
                                            <th>Small Unit</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->sku_code }}</td>
                                                <td>{{ $item->nama_item }}</td>
                                                <td>{{ $item->kategori->name_kategori }}</td>
                                                <td>{{ $item->brand->name_brand }}</td>
                                                <td>{{ $item->unit->name_unit }}</td>
                                                <td>{{ $item->unit->name_unit }}</td>
                                                <td>
                                                    {{-- edit  --}}
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#Edit-{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-pencil-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                                        </svg>
                                                    </button>
                                                    {{-- modal edit --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="Edit-{{ $item->id }}"
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
                                                                <form class="editformitem2" data-id="{{ $item->id }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Kode
                                                                                SKU</label>
                                                                            <input type="text" class="form-control"
                                                                                name="kode_sku"
                                                                                value="{{ $item->sku_code }}"
                                                                                id="exampleFormControlInput1"
                                                                                placeholder="masukkan Kode Kategori">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="exampleFormControlInput1">Nama
                                                                                Item</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nama_item"
                                                                                value="{{ $item->nama_item }}"
                                                                                id="exampleFormControlInput1"
                                                                                placeholder="masukkan nama Kategori">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6 ">
                                                                                <label>Kategori</label>
                                                                                <select id="id_kat_program"
                                                                                    name = "kategori_id"
                                                                                    class="form-control">
                                                                                    <option selected disabled riquired>
                                                                                        Choose...</option>
                                                                                    @foreach ($kategoris as $kats)
                                                                                        <option
                                                                                            value=" {{ $kats->id }}"
                                                                                            @selected($kats->id == $item->kategori_id)>
                                                                                            {{ $kats->name_kategori }}

                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6  ">
                                                                                <label>Brand</label>
                                                                                <select id="id_kat_program"
                                                                                    name = "brand_id"
                                                                                    class="form-control">
                                                                                    <option selected disabled riquired>
                                                                                        Choose...</option>
                                                                                    @foreach ($brands as $brandss)
                                                                                        <option
                                                                                            value=" {{ $brandss->id }}"
                                                                                            @selected($brandss->id == $item->brand_id)>
                                                                                            {{ $brandss->name_brand }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-6 ">
                                                                                <label>Unit</label>
                                                                                <select id="id_kat_program"
                                                                                    name = "unit_id" class="form-control">
                                                                                    <option selected disabled riquired>
                                                                                        Choose...</option>
                                                                                    @foreach ($units as $unitss)
                                                                                        <option
                                                                                            value="{{ $unitss->id }}"
                                                                                            @selected($unitss->id == $item->unit_id)>
                                                                                            {{ $unitss->name_unit }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-6 ">
                                                                                <label>Small Unit</label>
                                                                                <select id="id_kat_program"
                                                                                    name = "small_unit_id"
                                                                                    class="form-control">
                                                                                    <option selected disabled riquired>
                                                                                        Choose...</option>
                                                                                    @foreach ($s_units as $s_unitss)
                                                                                        <option
                                                                                            value=" {{ $s_unitss->id }}"
                                                                                            @selected($s_unitss->id == $item->small_unit_id)>
                                                                                            {{ $s_unitss->name_unit }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-md-6">
                                                                                <label for="exampleFormControlInput1">Ratio
                                                                                    Unit</label>
                                                                                <input type="text"
                                                                                    value="{{ $item->ratio_unit }}"
                                                                                    class="form-control" name="ratio_unit"
                                                                                    id="exampleFormControlInput1"
                                                                                    placeholder="masukkan Kode Kategori">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label
                                                                                    for="exampleFormControlInput1">Thumbnail</label>
                                                                                <div class="input-group ">
                                                                                    <div class="input-group-prepend">
                                                                                        <span
                                                                                            class="input-group-text">Upload</span>
                                                                                    </div>
                                                                                    <div class="custom-file">
                                                                                        <input name ="thumbnail"
                                                                                            type="file"
                                                                                            class="custom-file-input">
                                                                                        <label
                                                                                            class="custom-file-label">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <label
                                                                                    for="exampleFormControlInput1">Deskripsi</label>
                                                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $item->deskripsi }}</textarea>
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
                                                    <form action="{{ route('Item.destroy', $item->id) }}" method="POST"
                                                        class="form-delete-item mt-3">
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

                                                    {{-- detailimg --}}
                                                    <button type="button" class="btn btn-success mt-3"
                                                        data-toggle="modal" data-target="#Image-{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-file-earmark-image-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707v5.586l-2.73-2.73a1 1 0 0 0-1.52.127l-1.889 2.644-1.769-1.062a1 1 0 0 0-1.222.15L2 12.292V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zm-1.498 4a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                                                            <path
                                                                d="M10.564 8.27 14 11.708V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-.293l3.578-3.577 2.56 1.536 2.426-3.395z" />
                                                        </svg>
                                                    </button>
                                                    {{-- modal --}}
                                                    <div class="modal fade" id="Image-{{ $item->id }}"
                                                        data-backdrop="static" data-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">Image
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form class="editfotoitem2" data-id="{{ $item->id }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="form-group">
                                                                                    <h4 class="fw-bold">Thumbnail</h4>
                                                                                </div>

                                                                            </div>
                                                                            <div class="row justify-content-center">
                                                                                <img src="{{ asset($item->thumbnail) }}"
                                                                                    alt=""
                                                                                    style="    width:380px;
                                                                                height:380px;
                                                                                object-fit:cover;
                                                                                border-radius:6px;">
                                                                                <div class="input-group mt-4">
                                                                                    <div class="input-group-prepend ">
                                                                                        <span
                                                                                            class="input-group-text">Upload</span>
                                                                                    </div>
                                                                                    <div class="custom-file">
                                                                                        <input name ="thumbnail"
                                                                                            type="file"
                                                                                            class="custom-file-input">
                                                                                        <label
                                                                                            class="custom-file-label">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row mt-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Detail Gambar</label>
                                                                                        <div class="input-group mb-3">
                                                                                            <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                onclick="addInput2({{ $item->id }})">Tambah
                                                                                                +</button>

                                                                                        </div>
                                                                                        <div
                                                                                            id = "items-container2-{{ $item->id }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <h4>Detail Gambar</h4>
                                                                                    @if ($item->galeri->count())
                                                                                        @foreach ($item->galeri as $picture)
                                                                                            <div class="position-relative d-inline-block mr-2 mb-2"
                                                                                                id="picture-{{ $picture->id }}">

                                                                                                <img src="{{ asset('inputan/thumbnail/detailimg/' . $picture->image) }}"
                                                                                                    style="
                                                                                                    width:80px;
                                                                                                    height:80px;
                                                                                                    object-fit:cover;
                                                                                                    border-radius:6px;
                                                                                                ">

                                                                                                <button type="button"
                                                                                                    class="btn btn-danger btn-sm position-absolute"
                                                                                                    style="top:2px; right:2px; padding:2px 6px;"
                                                                                                    onclick="deletePicture({{ $picture->id }})">
                                                                                                    ×
                                                                                                </button>

                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <p>Gambar Kosong</p>
                                                                                    @endif
                                                                                </div>


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
                                                    {{-- akhir modal --}}
                                                    {{-- akhirimgae --}}
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
        $('#btnSaveItem').on('click', function() {
            let form = document.getElementById('formitem');
            let formData = new FormData(form);


            $.ajax({
                url: "{{ route('Tambah_Item') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('#btnSavekategori')
                        .prop('disabled', true)
                        .text('Menyimpan...');
                },

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Item berhasil ditambahkan',
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
                    $('#btnSavekategori')
                        .prop('disabled', false)
                        .text('Simpan kategori');
                }
            });
        });

        // edit
        $(document).on('submit', '.editformitem2', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_item') }}/" + id,
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

        // editgaleri
        $(document).on('submit', '.editfotoitem2', function(e) {
            e.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            $.ajax({
                url: "{{ url('/edit_foto_item') }}/" + id,
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
        $(document).on('submit', '.form-delete-item', function(e) {
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

        function addInput() {
            let uniqueId = Date.now();

            let html = `
        <div class="input-group mb-3" id="item-${uniqueId}">
            <div class="input-group-prepend">
                <span class="input-group-text">Upload</span>
            </div>

            <div class="custom-file">
                <input type="file" 
                       name="files[]" 
                       class="custom-file-input" 
                       id="file-${uniqueId}">
                <label class="custom-file-label" for="file-${uniqueId}">
                    Choose file
                </label>
            </div>
      
            <div class="input-group-append">
                <button type="button" 
                        class="btn btn-danger"
                        onclick="removeInput('${uniqueId}')">
                    Hapus
                </button>
            </div>
        </div>
        `;

            document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
        }

        // changedetailimage
        function addInput2(id) {
            let uniqueIds = Date.now();

            let html = `
    <div class="input-group mb-3" id="item-${uniqueIds}">
        <div class="input-group-prepend">
            <span class="input-group-text">Upload</span>
        </div>

        <div class="custom-file">
            <input type="file" 
                   name="files[]" 
                   class="custom-file-input" 
                   id="file-${uniqueIds}">
            <label class="custom-file-label" for="file-${uniqueIds}">
                Choose file
            </label>
        </div>

        <div class="input-group-append">
            <button type="button" 
                    class="btn btn-danger"
                    onclick="removeInput('${uniqueIds}')">
                Hapus
            </button>
        </div>
    </div>
    `;

            document.getElementById(`items-container2-${id}`)
                .insertAdjacentHTML('beforeend', html);
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('custom-file-input')) {
                e.target.nextElementSibling.innerText = e.target.files[0].name;
            }
        });

        function removeInput(id) {
            document.getElementById(`item-${id}`).remove();
        }

        // deletepicture
        function deletePicture(id) {
            if (!confirm('Hapus gambar ini?')) return;

            fetch(`/item/detail-picture/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('picture-' + id).remove();
                    } else {
                        alert('Gagal menghapus gambar');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan');
                });
        }
    </script>
    <!--**********************************!>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Content body end
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ***********************************-->
@endsection
