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
            $table->dropColumn(['title', 'description', 'release_date', 'image', 'slug']);
            $table->dropForeign(['director_id']);
            $table->dropColumn('director_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie', function (Blueprint $table) {
            $table->string("title");
            $table->string("description");
            $table->date("release_date");
            $table->foreignId("director_id")->constrained("director")->onDelete("set null");
            $table->string("image");
            $table->string("slug");
            $table->timestamps();
        });
    }
};
