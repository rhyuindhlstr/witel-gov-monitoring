<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('peluang_proyek_gs', function (Blueprint $table) {

            $table->string('id_am')->nullable()->after('wilayah_id');
            $table->string('nama_am')->nullable();
            $table->string('nama_gc')->nullable();
            $table->string('satker')->nullable();
            $table->string('judul_proyek')->nullable();

            $table->string('jenis_proyek')->nullable();

            $table->decimal('nilai_estimasi', 18, 2)->nullable();
            $table->decimal('nilai_realisasi', 18, 2)->nullable();
            $table->decimal('nilai_scaling', 18, 2)->nullable(); // ✅ FIX

            $table->enum('status_mytens', ['F0','F1','F2','F3','F4','F5'])->nullable();

            $table->enum('status_proyek', [
                'PROSPECT',
                'KEGIATAN_VALID',
                'WIN',
                'LOSE',
                'CANCEL'
            ])->default('PROSPECT');

            $table->string('mekanisme_pengadaan')->nullable();
            $table->date('start_pelaksanaan')->nullable();
            $table->date('end_pelaksanaan')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peluang_proyek_gs', function (Blueprint $table) {
            $table->dropColumn([
                'id_am',
                'nama_am',
                'nama_gc',
                'satker',
                'judul_proyek',
                'jenis_proyek',
                'nilai_estimasi',
                'nilai_realisasi',
                'nilai_scaling',
                'status_mytens',
                'status_proyek',
                'mekanisme_pengadaan',
                'start_pelaksanaan',
                'end_pelaksanaan',
                'keterangan'
            ]);
        });
    }
};
