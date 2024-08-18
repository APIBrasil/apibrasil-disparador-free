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
        Schema::create('disparos', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->string('templates_id')->nullable();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->bigInteger('qt_pending')->nullable();
            $table->bigInteger('qt_sent')->nullable();
            $table->bigInteger('qt_error')->nullable();

            $table->enum('status', ['pending', 'finish', 'paused', 'canceled'])->default('pending');

            //mode
            $table->enum('mode', ['agressive', 'normal', 'slow'])->default('normal');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disparos');
    }
};
