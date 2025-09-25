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
        Schema::table('movie', function (Blueprint $table) {
            $table->integer('tmdb_id')->unique()->nullable();
            $table->string('title')->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie', function (Blueprint $table) {
            $table->dropColumn(['tmdb_id', 'title', 'overview', 'poster_path', 'release_date']);
        });
    }
};
