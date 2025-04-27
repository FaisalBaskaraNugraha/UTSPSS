<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uts3items', function (Blueprint $table) { 
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Contoh: presisi 10 digit, 2 di belakang koma
            $table->integer('quantity')->default(0);
            // Foreign keys (disesuaikan dengan nama tabel yang baru)
            $table->foreignId('category_id')->constrained('uts3categories');
            $table->foreignId('supplier_id')->constrained('uts3suppliers');
            $table->foreignId('created_by')->constrained('uts3admins');
            // Jika perlu melacak siapa yg update terakhir
            // $table->foreignId('updated_by')->nullable()->constrained('uts3admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uts3items');
    }
};