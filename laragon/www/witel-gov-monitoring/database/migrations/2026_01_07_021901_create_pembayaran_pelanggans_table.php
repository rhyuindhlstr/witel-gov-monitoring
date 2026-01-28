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
        Schema::create('pembayaran_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->decimal('nominal', 15, 2);
            $table->enum('status_pembayaran', ['lancar', 'tertunda']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pelanggans');
    }
};
