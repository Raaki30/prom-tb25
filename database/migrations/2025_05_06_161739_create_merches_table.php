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
        Schema::create('merches', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->integer('grand_total');
            $table->string('metodebayar');
            $table->string('bukti')->nullable();
            $table->enum('status_bayar', ['pending', 'success', 'failed'])->default('pending');
            $table->enum('status_pickup', ['not_picked', 'picked_up'])->default('not_picked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merches');
    }
};
