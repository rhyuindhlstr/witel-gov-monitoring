<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peluang_proyek_gs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('jenis_layanan'); // 🔥 INI WAJIB ADA

            $table->enum('status', [
                'Pipeline',
                'Proposal',
                'Tender',
                'Evaluasi',
                'Deal',
                'Tidak Lanjut'
            ])->default('Pipeline');

            $table->unsignedBigInteger('wilayah_id');
            $table->date('tanggal_input');
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->foreign('wilayah_id')
                  ->references('id')
                  ->on('wilayahs')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peluang_proyek_gs');
    }
};
