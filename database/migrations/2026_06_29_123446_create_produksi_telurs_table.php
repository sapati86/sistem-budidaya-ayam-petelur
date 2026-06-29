<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi_telurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah_produksi');
            $table->integer('jumlah_rusak')->default(0);
            $table->enum('kualitas', ['A', 'B', 'C'])->default('A');
            $table->decimal('berat_rata_rata', 5, 2)->nullable(); // dalam gram
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_telurs');
    }
};