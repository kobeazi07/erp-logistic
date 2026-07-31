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
        Schema::create('tbldinternal_delivery', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_note_id');
            $table->integer('item_id');
            $table->decimal('qty', 18, 2);
            $table->integer('unit_id');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbldinternal_delivery');
    }
};
