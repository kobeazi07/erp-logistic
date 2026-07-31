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
        Schema::create('tblinternal_delivery', function (Blueprint $table) {
            $table->id();
            $table->string('prefix', 10);
            $table->integer('number');
            $table->string('internal_delivery_code');
            $table->date('date_transaction');
            $table->date('date_receive')->nullable();
            $table->integer('warehouse_from');
            $table->longText('remark')->nullable();
            $table->integer('warehouse_to');
            $table->tinyInteger('status')
                ->default(1)
                ->comment('1=Draft,2=Approved,3=Received');
            $table->integer('created_by');
            $table->integer('approved_by')
                ->nullable();
            $table->integer('received_by')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinternal_delivery');
    }
};
