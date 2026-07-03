<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;
    protected $table = 'tblgaleri';
    protected $guarded = [];

    public function galeri_id()
    {
        return $this->belongsTo(Galeri::class, 'galeri_id', 'id');
    }
}
