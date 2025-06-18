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
            $table->string('agency_id')->nullable();
            $table->string('mcmc_id')->nullable();
            $table->string('status');
            $table->timestamp('update_timestamp')->useCurrent();
            $table->text('remarks')->nullable();
            $table->timestamps();
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
