<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use App\Models\Inventory_Manage;
use App\Models\Warehouses;
use App\Models\InternalDelivery;
use App\Models\DInternalDelivery;
use App\Models\Items;
use App\Models\Unit;
use App\Models\Prefix;

class LogisticController extends Controller
{
    public function halamaninternaldelivery()
    {
        $internaldelivery = InternalDelivery::get();
        return view('backend.pages.internaldelivery', compact('internaldelivery'));
    }
    public function halamantinternaldelivery()
    {
        $warehouse = Warehouses::get();
        $warehousess = Warehouses::get();
        // $product = Items::get();
        $units = Unit::get();
        return view('backend.pages.tinternaldelivery', compact('warehouse', 'warehousess',  'units'));
    }


    public function dinternaldelivery($id)
    {
        $delivery = InternalDelivery::with([
            'warehouseFrom',
            'warehouseTo',
            'details.item'
        ])->findOrFail($id);

        return response()->json([
            'delivery' => $delivery,

        ]);
    }

    public function getItemsByWarehouse($warehouse_id)
    {
        $inventory = Inventory_Manage::with('item.unit', 'item.small_unit')
            ->where('warehouse_id', $warehouse_id)
            ->where('stok', '>', 0)
            ->get();

        return response()->json($inventory);
    }

    public function tambah_internaldelivery(Request $request)
    {

        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 8)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk Internal Delivery tidak ditemukan'
                ], 500);
            }
            $kode_internaldelivery = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);
            $internaldelivery = InternalDelivery::create([
                'internal_delivery_code'   => $kode_internaldelivery,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'warehouse_from' => $request->warehouse_from,
                'warehouse_to' => $request->warehouse_to,
                'remark' => $request->remark,
                'date_transaction' => $request->date_transaction,
                'status' => 1,
                'created_by' => Auth::id()
            ]);

            // increment number
            $prefix->increment('next_number');
            $internaldelivery_id = $internaldelivery->id;
            foreach ($request->item_id as $key => $itemId) {
                DInternalDelivery::create([
                    'delivery_note_id' => $internaldelivery_id,
                    'item_id'     => $itemId,
                    'qty'               => $request->qty[$key],
                    'unit_id'           => $request->unit_id[$key],
                    'remarks'            => $request->remarkd[$key] ?? null,

                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Cabang berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
