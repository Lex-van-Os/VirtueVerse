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
        Schema::table('study_trajectories', function (Blueprint $table) {
            Schema::table('study_trajectories', function (Blueprint $table) {
                $table->unsignedBigInteger('book_edition_id');
                $table->foreign('book_edition_id')->references('id')->on('book_editions');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_trajectories', function (Blueprint $table) {
            $table->dropForeign(['book_edition_id']);
            $table->dropColumn('book_edition_id');
        });
    }
};
