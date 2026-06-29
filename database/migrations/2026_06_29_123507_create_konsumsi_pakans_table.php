<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsumsi_pakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->foreignId('pakan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('satuan')->default('kg');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsumsi_pakans');
    }
};