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
        Schema::table('controls', function (Blueprint $table) {
            $table->dateTime('tanggal_mulai')->nullable()->change();
            $table->dateTime('tanggal_berakhir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('controls', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_berakhir')->nullable()->change();
        });
    }
};