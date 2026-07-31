<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalDelivery extends Model
{
    use HasFactory;
    protected $table = 'tblinternal_delivery';
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }
    public function warehouseFrom()
    {
        return $this->belongsTo(Warehouses::class, 'warehouse_from');
    }
    public function warehouseTo()
    {
        return $this->belongsTo(Warehouses::class, 'warehouse_to');
    }
    public function r_dinternald()
    {
        return $this->hasMany(DInternalDelivery::class, 'delivery_note_id');
    }
}
