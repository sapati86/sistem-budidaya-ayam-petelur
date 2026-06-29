<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kesehatan_ayams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ayam_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis_penyakit');
            $table->text('gejala');
            $table->text('tindakan');
            $table->enum('status', ['sembuh', 'perawatan', 'mati'])->default('perawatan');
            $table->date('tanggal_sembuh')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesehatan_ayams');
    }
};