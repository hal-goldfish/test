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
        Schema::table('books', function (Blueprint $table) {
            $table->string('author')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('publisher')->nullable()->change();
            $table->string('overview')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('author')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('publisher')->nullable(false)->change();
            $table->string('overview')->nullable(false)->change();
        });
    }
};
