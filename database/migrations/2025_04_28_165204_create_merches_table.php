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
            $table->timestamps();
            $table->string('order_id');
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->enum('status', ['waiting', 'success', 'failed'])->default('waiting');
            $table->enum('item1', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('item2', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('item3', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('item4', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->string('total_harga');
            $table->string('metodebayar');
            $table->string('bukti')->default('-');
            $table->boolean('pickup')->default(false);
            $table->enum('entry', ['1', '0'])->default('0');
            $table->dateTime('pickup_time')->nullable();
            $table->string('notes')->default('-');
        
            

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
