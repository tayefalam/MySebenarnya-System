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
        Schema::dropIfExists('inquiry_progress');
    }
};
