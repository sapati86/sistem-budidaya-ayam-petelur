<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pakan')->unique();
            $table->string('nama');
            $table->enum('jenis', ['konsentrat', 'jagung', 'dedak', 'premix', 'lainnya'])->default('konsentrat');
            $table->integer('stok');
            $table->string('satuan')->default('kg');
            $table->decimal('harga_satuan', 10, 2);
            $table->date('tanggal_kadaluarsa');
            $table->integer('stok_minimal')->default(10);
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakans');
    }
};