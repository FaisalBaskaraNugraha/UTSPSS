<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uts3suppliers', function (Blueprint $table) { 
            $table->id();
            $table->string('name', 100);
            $table->string('contact_info', 100)->nullable();
            // Foreign key ke tabel uts3admins (sesuai perubahan sebelumnya)
            $table->foreignId('created_by')->constrained('uts3admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uts3suppliers'); 
    }
};
