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
use App\Models\Cabang;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Kategori;
use App\Models\Items;
use App\Models\Galeri;
use App\Models\Inventory_Manage;
use App\Models\Jabatan;
use App\Models\User;
use App\Models\Prefix;

class MasterController extends Controller
{
    public function dashboard()
    {
        return view('backend.pages.dashboard');
    }
    public function halamancabang()
    {
        $cabang = Cabang::get();
        return view('backend.pages.cabang', compact('cabang'));
    }
    public function tambah_cabang(Request $request)
    {

        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 1)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk jabatan tidak ditemukan'
                ], 500);
            }
            $fill_pusat = $request->has('is_pusat') ? 1 : 0;

            if ($fill_pusat == 1) {
                // 1. matikan pusat lama
                Cabang::where('is_pusat', 1)->update([
                    'is_pusat' => 0
                ]);
            }

            $kode_cabang = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);
            $cabang = Cabang::create([
                'kode_cabang'   => $kode_cabang,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'is_pusat' => $fill_pusat,
                'alamat' => $request->alamat
            ]);

            // increment number
            $prefix->increment('next_number');

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
    public function edit_cabang(Request $request, $id)
    {
        $cabang =   Cabang::find($id);
        $fill_pusat = $request->has('is_pusat') ? 1 : 0;

        if ($fill_pusat == 1) {
            // 1. matikan pusat lama
            Cabang::where('is_pusat', 1)->update([
                'is_pusat' => 0
            ]);
        }

        $data = [
            'kode_cabang'   => $cabang->kode_cabang,
            'alamat' => $request->alamat,
            'is_pusat' => $fill_pusat
        ];

        // update data
        Cabang::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Cabang berhasil diupdate'
        ]);
    }
    public function destroy(Cabang $cabang)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 1)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix tidak ditemukan'
                ], 500);
            }

            $number = $cabang->number;
            if ($number == ($prefix->next_number - 1)) {
                $prefix->next_number = $prefix->next_number - 1;
                $prefix->save();
            }
            $cabang->delete();
            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data Cabang berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // vendor
    public function halamanvendor()
    {
        $vendor = Vendor::get();
        return view('backend.pages.vendor', compact('vendor'));
    }
    public function tambah_vendor(Request $request)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 6)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk jabatan tidak ditemukan'
                ], 500);
            }

            $kode_vendor = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);
            $vendor = Vendor::create([
                'kode_vendor'   => $kode_vendor,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'name_vendor' => $request->name_vendor
            ]);

            // increment number
            $prefix->increment('next_number');

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Vendor berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit_vendor(Request $request, $id)
    {
        $vendor =   Vendor::find($id);
        $data = [
            'kode_vendor'   => $vendor->kode_vendor,
            'name_vendor' => $request->name_vendor
        ];

        // update data
        Vendor::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Vendor berhasil diupdate'
        ]);
    }
    public function destroyVendor(Vendor $vendor)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 6)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix tidak ditemukan'
                ], 500);
            }

            $number = $vendor->number;
            if ($number == ($prefix->next_number - 1)) {
                $prefix->next_number = $prefix->next_number - 1;
                $prefix->save();
            }
            $vendor->delete();
            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data vendor berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // brand
    public function halamanbrand()
    {
        $brand = Brand::get();
        return view('backend.pages.brand', compact('brand'));
    }
    public function tambah_brand(Request $request)
    {

        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 3)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk jabatan tidak ditemukan'
                ], 500);
            }

            $kode_brand = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);

            $brand = Brand::create([
                'kode_brand'   => $kode_brand,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'name_brand' => $request->name_brand
            ]);

            // increment number
            $prefix->increment('next_number');

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'brand berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit_brand(Request $request, $id)
    {
        $brand =   Brand::find($id);
        $data = [
            'kode_brand'   => $brand->kode_brand,
            'name_brand' => $request->name_brand
        ];

        // update data
        Brand::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Brand berhasil diupdate'
        ]);
    }
    public function destroyBrand(Brand $brand)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 3)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix tidak ditemukan'
                ], 500);
            }

            $number = $brand->number;
            if ($number == ($prefix->next_number - 1)) {
                $prefix->next_number = $prefix->next_number - 1;
                $prefix->save();
            }
            // hapus data
            $brand->delete();

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data Brand berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // unit
    public function halamanunit()
    {
        $unit = Unit::get();
        return view('backend.pages.unit', compact('unit'));
    }
    public function tambah_unit(Request $request)
    {


        $unit = Unit::create([
            'kode_unit'   => $request->kode_unit,
            'name_unit' => $request->name_unit
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Portfolio berhasil diupdate'
        ]);
    }
    public function edit_unit(Request $request, $id)
    {
        $unit =   Unit::find($id);
        $data = [
            'kode_unit'   => $request->kode_unit,
            'name_unit' => $request->name_unit
        ];

        // update data
        Unit::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Unit berhasil diupdate'
        ]);
    }
    public function destroyunit(Unit $unit)
    {

        $unit->delete();

        return response()->json([
            'status'  => 1,
            'message' => 'Data Unit berhasil dihapus'
        ]);
    }
    // Kategori
    public function halamankategori()
    {
        $kategori = kategori::get();
        return view('backend.pages.kategori', compact('kategori'));
    }
    public function tambah_kategori(Request $request)
    {

        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 4)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk jabatan tidak ditemukan'
                ], 500);
            }

            $kode_kategori = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);
            $kategori = Kategori::create([
                'kode_kategori'   => $kode_kategori,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'name_kategori' => $request->name_kategori
            ]);
            // increment number
            $prefix->increment('next_number');

            DB::commit();
            return response()->json([
                'status' => 1,
                'message' => 'Kategori berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit_kategori(Request $request, $id)
    {
        $kategori =   Kategori::find($id);
        $data = [
            'kode_kategori'   => $kategori->kode_kategori,
            'name_kategori' => $request->name_kategori
        ];

        // update data
        Kategori::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data Kategori berhasil diupdate'
        ]);
    }
    public function destroyKategori(Kategori $kategori)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 4)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix tidak ditemukan'
                ], 500);
            }

            $number = $kategori->number;
            if ($number == ($prefix->next_number - 1)) {
                $prefix->next_number = $prefix->next_number - 1;
                $prefix->save();
            }
            $kategori->delete();
            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data Kategori berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // jabatan
    // Kategori
    public function halamanjabatan()
    {
        $jabatan = Jabatan::get();
        return view('backend.pages.jabatan', compact('jabatan'));
    }
    public function tambah_jabatan(Request $request)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 2)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix untuk jabatan tidak ditemukan'
                ], 500);
            }

            $kode_jabatan = $prefix->prefix . str_pad($prefix->next_number, 3, '0', STR_PAD_LEFT);

            $jabatan = Jabatan::create([
                'kode_jabatan' => $kode_jabatan,
                'prefix' => $prefix->prefix,
                'number' => $prefix->next_number,
                'name_jabatan' => $request->name_jabatan
            ]);

            // increment number
            $prefix->increment('next_number');

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'jabatan berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit_jabatan(Request $request, $id)
    {
        $jabatan =  Jabatan::find($id);
        $data = [
            'kode_jabatan'   => $jabatan->kode_jabatan,
            'name_jabatan' => $request->name_jabatan
        ];

        // update data
        Jabatan::where('id', $id)->update($data);
        //  dd($id);   

        return response()->json([
            'status' => 1,
            'message' => 'Data jabatan berhasil diupdate'
        ]);
    }
    public function destroyjabatan(Jabatan $jabatan)
    {
        DB::beginTransaction();

        try {
            $prefix = Prefix::where('type', 2)->lockForUpdate()->first();

            if (!$prefix) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Prefix tidak ditemukan'
                ], 500);
            }

            $number = $jabatan->number;
            if ($number == ($prefix->next_number - 1)) {
                $prefix->next_number = $prefix->next_number - 1;
                $prefix->save();
            }
            // hapus data
            $jabatan->delete();

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data jabatan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
        // $jabatan->delete();

        // return response()->json([
        //     'status'  => 1,
        //     'message' => 'Data jabatan berhasil dihapus'
        // ]);
    }


    public function halamanitem()
    {
        $item = Items::get();
        $brand = Brand::get();
        $unit = Unit::get();
        $s_unit = Unit::get();
        $kategori = Kategori::get();
        $brands = Brand::get();
        $units = Unit::get();
        $s_units = Unit::get();
        $kategoris = Kategori::get();
        return view('backend.pages.item', compact('brands', 'units', 's_units', 'kategoris', 'item', 'brand', 'unit', 's_unit', 'kategori'));
    }

    public function tambah_item(Request $request)
    {

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = uniqid() . '_thumbnail_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('inputan/thumbnail/img'), $thumbnailName);
            $thumbnailPath = 'inputan/thumbnail/img/' . $thumbnailName;
        }
        $item = Items::create([
            'sku_code'   => $request->kode_sku,
            'nama_item' => $request->nama_item,
            'brand_id' => $request->brand_id,
            'unit_id' => $request->unit_id,
            'small_unit_id' => $request->small_unit_id,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'ratio_unit' => $request->ratio_unit,
            'thumbnail' => $thumbnailPath
        ]);
        $item_id = $item->id;
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('inputan/thumbnail/detailimg'), $fileName);

                Galeri::create([
                    'produk_id' => $item_id,
                    'image'     => $fileName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $cabang = Cabang::where('is_pusat', 1)->first();

        if ($item_id && $cabang) {
            Inventory_Manage::create([
                'item_id'   => $item_id,
                'cabang_id' => $cabang->id,
                'stok' => 0
            ]);
        }
        return response()->json([
            'status' => 1,
            'message' => 'Produk berhasil diupdate'
        ]);
    }
    public function edit_item(Request $request, $id)
    {
        // dd($request->all());
        // $thumbnailPath = null;
        // if ($request->hasFile('thumbnail')) {
        //     $thumbnail = $request->file('thumbnail');
        //     $thumbnailName = uniqid() . '_thumbnail_' . $thumbnail->getClientOriginalName();
        //     $thumbnail->move(public_path('inputan/thumbnail/img'), $thumbnailName);
        //     $thumbnailPath = 'inputan/thumbnail/img/' . $thumbnailName;
        // }
        $item = Items::find($id);
        $data =
            [
                'sku_code'   => $request->kode_sku,
                'nama_item' => $request->nama_item,
                'brand_id' => $request->brand_id,
                'unit_id' => $request->unit_id,
                'small_unit_id' => $request->small_unit_id,
                'kategori_id' => $request->kategori_id,
                'deskripsi' => $request->deskripsi,
                'ratio_unit' => $request->ratio_unit,
            ];
        Items::where('id', $id)->update($data);
        return response()->json([
            'status' => 1,
            'message' => 'Produk berhasil diupdate'
        ]);
    }
    public function edit_foto_item(Request $request, $id)
    {
        // dd($request->all());

        $item = Items::find($id);
        $data = [];
        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = uniqid() . '_thumbnail_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('inputan/thumbnail/img'), $thumbnailName);

            $data['thumbnail'] = 'inputan/thumbnail/img/' . $thumbnailName;
        }

        Items::where('id', $id)->update($data);
        $item_id = $id;
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('inputan/thumbnail/detailimg'), $fileName);

                Galeri::create([
                    'produk_id' => $item_id,
                    'image'     => $fileName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return response()->json([
            'status' => 1,
            'message' => 'Produk berhasil diupdate'
        ]);
    }
    public function destroyItem(Items $item)
    {
        DB::beginTransaction();

        try {
            $item->galeri()->delete();
            $item->inventories()->delete();

            $item->delete();

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Data Item berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function deletePicture($id)
    {
        $picture = Galeri::findOrFail($id);

        // hapus file fisik
        $filePath = public_path($picture->foto);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $picture->delete();

        return response()->json([
            'success' => true
        ]);
    }
    public function halamanlogin()
    {
        return view('backend.layouts.login');
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'redirect' => route('Dashboard') // sesuaikan route tujuan
            ]);
        }
        // Password salah
        return response()->json([
            'success' => false,
            'message' => 'Password salah! Silakan coba lagi.'
        ], 401);
    }
    public function user_logout(Request $request)
    {

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
