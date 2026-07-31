<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_Manage extends Model
{
    use HasFactory;
    protected $table = 'tblinventory_manage';
    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouses::class, 'warehouse_id');
    }
}
