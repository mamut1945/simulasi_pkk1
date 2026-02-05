<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('id_inventaris', 10)->unique();
            $table->string('nama_barang');
            $table->enum('kondisi', ['Baik', 'Perbaikan', 'Rusak'])->default('Baik');
            $table->integer('stok');
            $table->date('tanggal_register');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
