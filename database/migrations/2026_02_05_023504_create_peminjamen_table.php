<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->string('id_inventaris');
            $table->foreign('id_inventaris')->references('id_inventaris')->on('inventaris')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('nama_peminjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['Belum Kembali', 'Sudah Kembali', 'Proses'])->default('Proses');
            $table->string('petugas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
