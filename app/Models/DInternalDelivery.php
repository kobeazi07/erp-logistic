<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DInternalDelivery extends Model
{
    use HasFactory;
    protected $table = 'tbldinternal_delivery';
    protected $guarded = [];
    public function dinternald()
    {
        return $this->belongsTo(InternalDelivery::class, 'delivery_note_id');
    }
}
