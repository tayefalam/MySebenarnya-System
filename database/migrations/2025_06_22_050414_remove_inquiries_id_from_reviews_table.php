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
        Schema::table('reviews', function (Blueprint $table) {
             $table->dropForeign(['inquiries_id']);
             $table->dropColumn('inquiries_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('inquiries_id')->nullable();
            $table->foreign('inquiries_id')->references('id')->on('inquiries')->onDelete('cascade');
        });
    }
};
