<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Add columns
            $table->string('author');
            $table->string('open_library_key')->nullable();
            $table->string('editions_key')->nullable();

            // Remove columns
            $table->dropColumn('pages');
            $table->dropColumn('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            // Reverse the changes in the down method
            $table->dropColumn('author');
            $table->dropColumn('open_library_key');
            $table->dropColumn('editions_key');
            $table->integer('pages');
            $table->string('language');
        });
    }
};
