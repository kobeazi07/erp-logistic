<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblitems', function (Blueprint $table) {
            $table->id();
            $table->string('sku_code');
            $table->string('nama_item');
            $table->integer('brand_id');
            $table->integer('unit_id');
            $table->integer('small_unit_id');
            $table->integer('kategori_id');
            $table->longText('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblitems');
    }
};
