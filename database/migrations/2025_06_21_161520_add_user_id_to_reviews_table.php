<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
        if (!Schema::hasColumn('reviews', 'User_ID')) {
        $table->string('User_ID', 10)->after('inquiries_id');
        $table->foreign('User_ID')->references('User_ID')->on('user')->onDelete('cascade');
    }
    });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'User_ID')) {
                // Drop foreign key first if it exists
                $table->dropForeign(['User_ID']);
                $table->dropColumn('User_ID');
            }
        });
    }
};
