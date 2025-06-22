<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{

        // Drop foreign and column from reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Create new inquiry_progress table
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add user_id column to reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });

        // Drop inquiry_progress table
        Schema::dropIfExists('inquiry_progress');
    }
};

