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
        Schema::table('merches', function (Blueprint $table) {
            $table->string('varian_item1')->nullable()->after('item1');
            $table->string('varian_item2')->nullable()->after('item2');
            $table->string('varian_item3')->nullable()->after('item3');
            $table->string('varian_item4')->nullable()->after('item4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
