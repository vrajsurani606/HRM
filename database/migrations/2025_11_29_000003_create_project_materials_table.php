<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_report_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            
            $table->unique(['project_id', 'material_id', 'material_report_id'], 'project_material_report_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_materials');
    }
};
