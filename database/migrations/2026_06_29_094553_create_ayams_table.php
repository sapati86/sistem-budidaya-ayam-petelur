<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->string('kode_ayam')->unique();
            $table->enum('jenis', ['pullet', 'layer', 'pejantan'])->default('layer');
            $table->integer('umur_hari');
            $table->enum('status_kesehatan', ['sehat', 'sakit', 'mati'])->default('sehat');
            $table->date('tanggal_masuk');
            $table->date('tanggal_produksi')->nullable(); // kapan mulai bertelur
            $table->integer('produksi_telur_per_minggu')->default(0);
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayams');
    }
};