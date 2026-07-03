<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'tblitems';
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function small_unit()
    {
        return $this->belongsTo(Unit::class, 'small_unit_id', 'id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'produk_id');
    }
    public function inventories()
    {
        return $this->hasMany(Inventory_Manage::class, 'item_id');
    }
}
