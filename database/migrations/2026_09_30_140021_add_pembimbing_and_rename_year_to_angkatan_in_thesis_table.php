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
        Schema::table('thesis', function (Blueprint $table) {
            if (!Schema::hasColumn('thesis', 'pembimbing_1')) {
                $table->string('pembimbing_1')->nullable()->after('author');
            }
            if (!Schema::hasColumn('thesis', 'pembimbing_2')) {
                $table->string('pembimbing_2')->nullable()->after('pembimbing_1');
            }
            if (Schema::hasColumn('thesis', 'year') && !Schema::hasColumn('thesis', 'angkatan')) {
                $table->renameColumn('year', 'angkatan');
            } elseif (!Schema::hasColumn('thesis', 'angkatan')) {
                $table->integer('angkatan')->nullable()->after('program_study');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            if (Schema::hasColumn('thesis', 'angkatan') && !Schema::hasColumn('thesis', 'year')) {
                $table->renameColumn('angkatan', 'year');
            }
            if (Schema::hasColumn('thesis', 'pembimbing_2')) {
                $table->dropColumn('pembimbing_2');
            }
            if (Schema::hasColumn('thesis', 'pembimbing_1')) {
                $table->dropColumn('pembimbing_1');
            }
        });
    }
};
