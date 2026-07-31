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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Models\Prefix;
use App\Models\Cabang;
use App\Models\Inventory_Manage;
use App\Models\Warehouses;

class SettingController extends Controller
{
    public function halamanprefix()
    {
        $prefix = Prefix::get();
        return view('backend.pages.prefix', compact('prefix'));
    }
    public function edit_prefix(Request $request, $id)
    {
        $prefix =  Prefix::find($id);
        $data = [
            'prefix'   => $request->prefix,
            'next_number' => $request->next_number
        ];

        // update data
        Prefix::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Cabang berhasil diupdate'
        ]);
    }

    public function halamanmminstock()
    {
        $minstock = Prefix::get();
        return view('backend.pages.minstock', compact('prefix'));
    }

    public function halamanstockopname()
    {
        $cabang = Cabang::get();
        return view('backend.pages.stockopname', compact('cabang'));
    }
    public function halamandstockopname($id)
    {
        $cabang = Cabang::find($id);
        $inv_manage = Inventory_Manage::where('cabang_id', $id)->get();
        return view('backend.pages.dstockopname', compact('cabang', 'inv_manage', 'id'));
    }
    public function update_stock(Request $request)
    {
        // dd($request->all());
        $stok = $request->stok;
        $ids  = $request->inv_manage_id;

        foreach ($ids as $index => $id) {
            Inventory_Manage::where('id', $id)->update([
                'stok' => $stok[$index]
            ]);
        }

        return redirect()->back()->with('success', 'Stok berhasil diupdate');
    }
    public function importStock(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048'
        ]);

        $data = Excel::toArray([], $request->file('file'));

        DB::beginTransaction();

        try {
            $updated = 0;
            $skipped = 0;
            $errors  = [];

            foreach ($data[0] as $key => $row) {

                if ($key == 0) continue;

                // bersihkan data
                $inv_id = trim($row[1] ?? '');
                $stok   = trim($row[4] ?? '');
                //validasi
                if (!$inv_id || !is_numeric($stok) || $stok < 0) {
                    $skipped++;
                    $errors[] = "Baris " . ($key + 1) . " invalid";
                    continue;
                }
                //update + validasi keberadaan
                $affected = Inventory_Manage::where('id', $inv_id)
                    ->update(['stok' => $stok]);

                if ($affected) {
                    $updated++;
                } else {
                    $skipped++;
                    $errors[] = "Baris " . ($key + 1) . " ID tidak ditemukan";
                }
            }

            DB::commit();

            return back()->with(
                'success',
                "✔️ Updated: $updated | ❌ Skipped: $skipped"
            )->with('errors_import', $errors);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
    public function updateStockSingle(Request $request)
    {
        Inventory_Manage::where('id', $request->id)
            ->update(['stok' => $request->stok]);

        return response()->json(['status' => 1]);
    }
    public function downloadTemplateStock($id)
    {
        $data = \App\Models\Inventory_Manage::with('item')
            ->where('cabang_id', $id)
            ->get();

        return Excel::download(new class($data) implements
            \Maatwebsite\Excel\Concerns\FromArray,
            \Maatwebsite\Excel\Concerns\WithEvents {

            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                $rows[] = ['no', 'inv_manage_id', 'sku_code', 'nama_item', 'stok'];

                foreach ($this->data as $key => $d) {
                    $rows[] = [
                        $key + 1,
                        $d->id,
                        $d->item->sku_code,
                        $d->item->nama_item,
                        $d->stok
                    ];
                }

                return $rows;
            }

            public function registerEvents(): array
            {
                return [
                    \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {

                        $sheet = $event->sheet->getDelegate();


                        //lock semua kolom A - D
                        $sheet->getStyle('A:D')->getProtection()
                            ->setLocked(Protection::PROTECTION_PROTECTED);

                        //  unlock semua kolom E
                        $sheet->getStyle('E:E')->getProtection()
                            ->setLocked(Protection::PROTECTION_UNPROTECTED);
                        // HIDE kolom B (inv_manage_id)
                        $sheet->getColumnDimension('B')->setVisible(false);
                        // aktifkan proteksi sheet
                        $sheet->getProtection()->setSheet(true);
                    }
                ];
            }
        }, 'template_stock.xlsx');
    }
}
