<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        // Cek apakah kolom 'status' sudah ada
        if (!Schema::hasColumn('peluang_proyek_gs', 'status')) {
            Schema::table('peluang_proyek_gs', function (Blueprint $table) {
                $table->string('status')->default('Proposal')->after('wilayah_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('peluang_proyek_gs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
