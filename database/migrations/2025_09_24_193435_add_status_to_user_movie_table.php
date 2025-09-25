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
        Schema::table('user_movie', function (Blueprint $table) {
            $table->enum('status', ['want_to_watch', 'watched'])->default('want_to_watch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_movie', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
