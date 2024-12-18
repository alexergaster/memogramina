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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('image', 100)->nullable()->default(env('APP_URL') . ':' . env('APP_PORT') . "/storage/profille/default.jpg");
            $table->string("username", 100);
            $table->string("name", 100)->nullable();
            $table->string("email", 100)->unique();
            $table->string('password', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
