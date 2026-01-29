<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aktivitas_marketing', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peluang_proyek_gs_id')
                ->constrained('peluang_proyek_gs')
                ->onDelete('cascade');

            $table->date('tanggal');
            $table->string('jenis_aktivitas');
            $table->string('hasil');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aktivitas_marketing');
    }
};
