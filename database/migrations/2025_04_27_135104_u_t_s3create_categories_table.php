<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uts3categories', function (Blueprint $table) { 
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('uts3admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uts3categories'); 
    }
};
