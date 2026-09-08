<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('author');
        });
    }

    public function down(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->dropColumn('nim');
        });
    }
};
