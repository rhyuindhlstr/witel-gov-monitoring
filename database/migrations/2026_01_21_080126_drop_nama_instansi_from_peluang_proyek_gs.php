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
    Schema::table('peluang_proyek_gs', function (Blueprint $table) {
        if (Schema::hasColumn('peluang_proyek_gs', 'nama_instansi')) {
            $table->dropColumn('nama_instansi');
        }
    });
}

public function down(): void
{
    Schema::table('peluang_proyek_gs', function (Blueprint $table) {
        $table->string('nama_instansi')->nullable();
    });
}

};
