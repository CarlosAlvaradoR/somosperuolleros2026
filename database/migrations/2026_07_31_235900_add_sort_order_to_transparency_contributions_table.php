<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega orden manual para que Transparencia pueda reordenarse desde el dashboard.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('transparency_contributions', 'sort_order')) {
            Schema::table('transparency_contributions', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->default(0)->index()->after('contribution_date');
            });
        }

        DB::table('transparency_contributions')
            ->whereNull('deleted_at')
            ->orderByDesc('contribution_date')
            ->orderByDesc('id')
            ->get(['id'])
            ->values()
            ->each(function ($contribution, int $index) {
                DB::table('transparency_contributions')
                    ->where('id', $contribution->id)
                    ->update(['sort_order' => ($index + 1) * 10]);
            });
    }

    /**
     * Retira el orden manual si se revierte esta mejora.
     */
    public function down(): void
    {
        if (Schema::hasColumn('transparency_contributions', 'sort_order')) {
            Schema::table('transparency_contributions', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};
