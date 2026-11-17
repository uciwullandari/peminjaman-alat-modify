<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_peran_after_insert');

        DB::table('log_aktivitas')
            ->where('aksi', 'beri_peran')
            ->delete();
    }

    public function down(): void
    {
        // Role assignment logging is intentionally disabled.
    }
};
