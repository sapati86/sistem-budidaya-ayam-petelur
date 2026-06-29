<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kandangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kandang')->unique();
            $table->string('nama');
            $table->integer('kapasitas');
            $table->integer('jumlah_ayam_aktif')->default(0);
            $table->text('lokasi');
            $table->enum('status', ['aktif', 'nonaktif', 'perawatan'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kandangs');
    }
};