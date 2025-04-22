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
        Schema::table('tikets', function (Blueprint $table) {
            // Change the 'entry' column to boolean
            $table->boolean('entry')->default(false)->change();
        });

        Schema::table('nis', function (Blueprint $table) {
            // Change the 'sudah_beli' column to boolean
            $table->boolean('sudah_beli')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            // Revert the 'entry' column back to integer
            $table->integer('entry')->default(0)->change();
        });

        Schema::table('nis', function (Blueprint $table) {
            // Revert the 'sudah_beli' column back to integer
            $table->integer('sudah_beli')->default(0)->change();
        });
    }
};
