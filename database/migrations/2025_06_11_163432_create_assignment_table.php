<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentTable extends Migration
{
    public function up()
    {
        Schema::create('assignment', function (Blueprint $table) {
            $table->id('Assignment_ID'); // primary key
            $table->foreignId('inquiry_id')->constrained('inquiries')->onDelete('cascade');
            $table->string('MCMC_ID', 10);
            $table->string('Agency_ID', 10);
            $table->date('Assigned_Date');
            $table->boolean('Reassigned');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment');
    }
}
