@extends('backend.layouts.index')

@section('konten')
    Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Stok Opname</h4>
                        <span class="ml-1">{{ $cabang->alamat }}</span>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('HalamanStockOpname') }}">List Cabang</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $cabang->kode_cabang }}</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <a href="{{ url('/download-template-stock/' . $id) }}" class="btn btn-success">
                        Download Template
                    </a>
                </div>
                <div class="col-lg-6 text-right">
                    <form action="{{ route('import.stock') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required>
                        <button type="submit" class="btn btn-success">Import Excel</button>
                    </form>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="example" class="display">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode SKU</th>
                                            <th>Nama Item</th>
                                            <th>Unit</th>
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inv_manage as $key => $inv)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $inv->item->sku_code }}</td>
                                                <td>{{ $inv->item->nama_item }}</td>
                                                <td>{{ $inv->item->unit->name_unit }}</td>
                                                <td>
                                                    <input type="number" class="form-control stok-input"
                                                        data-id="{{ $inv->id }}" value="{{ $inv->stok }}">
                                                    {{-- <input type="hidden" name="inv_manage_id[]"
                                                            value="{{ $inv->id }}"> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary mt-3 float-right" id="btnRefresh">
                                    Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('form').on('submit', function() {
            Swal.fire({
                title: 'Importing...',
                text: 'Sedang memproses file',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
        $('input[name="file"]').on('change', function() {
            let file = this.files[0];

            if (file) {
                let ext = file.name.split('.').pop().toLowerCase();

                if (!['xlsx', 'csv'].includes(ext)) {
                    alert('File harus Excel (.xlsx / .csv)');
                    $(this).val('');
                }
            }
        });
        $('#btnRefresh').on('click', function() {
            location.reload();
        });
        // js autosave
        $(document).on('change', '.stok-input', function() {
            let input = $(this);
            let id = input.data('id');
            let stok = input.val();
            let min = input.data('min');

            // warna loading
            input.css('background', '#fff3cd');

            $.ajax({
                url: '/update-stock-single',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    stok: stok
                },
                success: function() {
                    // sukses → hijau
                    input.css('background', '#d4edda');

                    // warning stok minimum
                    if (stok < min) {
                        input.css('background', '#f8d7da');
                    }
                },
                error: function() {
                    // gagal → merah tua
                    input.css('background', '#f5c6cb');
                }
            });
        });
        $(document).on('change', '.stok-input', function() {
            $(this).css('background', '#d4edda'); // hijau
        });
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
