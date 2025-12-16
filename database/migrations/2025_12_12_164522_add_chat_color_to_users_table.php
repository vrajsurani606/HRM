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
        Schema::table('users', function (Blueprint $table) {
            $table->string('chat_color', 20)->nullable()->after('photo_path');
        });
        
        // Assign unique colors to existing users
        $colors = [
            '#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', 
            '#ef4444', '#06b6d4', '#84cc16', '#f97316', '#14b8a6',
            '#a855f7', '#3b82f6', '#eab308', '#e11d48', '#0ea5e9'
        ];
        
        $users = \App\Models\User::whereNull('chat_color')->get();
        foreach ($users as $index => $user) {
            $user->chat_color = $colors[$index % count($colors)];
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('chat_color');
        });
    }
};
