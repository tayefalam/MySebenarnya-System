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
<<<<<<< HEAD:database/migrations/2025_06_21_160717_remove_user_id_from_reviews_table.php
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
=======
        Schema::create('inquiry_progress', function (Blueprint $table) {
            $table->id('progress_id');
            $table->unsignedBigInteger('inquiry_id');
            $table->unsignedBigInteger('agency_id');
            $table->enum('status', ['Pending', 'In Progress', 'Resolved', 'Rejected']);
            $table->enum('remarks', ['Acknowledged', 'Under Review', 'Completed'])->nullable();
            $table->timestamp('update_timestamp')->useCurrent();
            $table->timestamps();

            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('cascade');
            $table->foreign('agency_id')->references('id')->on('users')->onDelete('cascade');
>>>>>>> a475ae09d5e7d0662df260e489df6e852d566804:database/migrations/2025_06_18_214807_create_inquiry_progress_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });
    }
};
