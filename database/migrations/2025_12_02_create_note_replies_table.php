<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_id');
            $table->unsignedBigInteger('user_id');
            $table->longText('content');
            $table->boolean('is_admin_reply')->default(false);
            $table->timestamps();

            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('note_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_replies');
    }
};
