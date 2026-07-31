@extends('backend.layouts.index')

@section('konten')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Gudang {{ $warehouse->warehouse_name }}</h4>
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
                                            <th>Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itemv as $key => $itemv)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $itemv->item->sku_code }}</td>
                                                <td>{{ $itemv->item->nama_item }}</td>
                                                <td>{{ $itemv->item->kategori->name_kategori }}</td>
                                                <td>{{ $itemv->item->brand->name_brand }}</td>
                                                <td>{{ $itemv->item->unit->name_unit }}</td>
                                                <td>{{ $itemv->item->unit->name_unit }}</td>
                                                <td>{{ $itemv->stok }}</td>
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

    <!--**********************************!>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Content body end
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ***********************************-->
@endsection
