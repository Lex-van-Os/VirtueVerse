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
        Schema::create('read_minutes_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_entry_id');
            $table->foreign('study_entry_id')->references('id')->on('study_entries');
            $table->integer('read_minutes');
            $table->date('date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('read_minutes_entries');
    }
};
