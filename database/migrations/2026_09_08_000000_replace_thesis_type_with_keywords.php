<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('title');
            $table->dropColumn('type');
        });

        DB::table('thesis')->whereNull('keywords')->update([
            'keywords' => DB::raw('title'),
        ]);
    }

    public function down(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->enum('type', ['kcv', 'kbj', 'rpl'])->nullable()->after('abstract');
            $table->dropColumn('keywords');
        });
    }
};
