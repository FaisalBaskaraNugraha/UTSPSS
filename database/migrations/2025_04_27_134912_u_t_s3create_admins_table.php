<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uts3admins', function (Blueprint $table) { 
            $table->id(); // Kolom id (int, primary key, auto increment)
            $table->string('username', 50)->unique();
            $table->string('password', 100); // Ingat untuk hash password!
            $table->string('email', 100)->unique()->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at (datetime)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uts3admins'); 
    }
};
