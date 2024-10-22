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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->text('text')->nullable();
            $table->string('path')->nullable();
            $table->enum('type', ['text', 'image', 'file'])->default('text');

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop foreign key
        Schema::table('templates', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('templates');
    }
};
