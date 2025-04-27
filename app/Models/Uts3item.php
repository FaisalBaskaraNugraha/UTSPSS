<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Uts3item extends Model
{
    use HasFactory;

    protected $table = 'uts3items'; // Hubungkan dengan nama tabel

    protected $fillable = [
        'name', 'description', 'price', 'quantity', 'category_id', 'supplier_id', 'created_by',
        // 'updated_by', // Jika ada kolom updated_by
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Uts3category::class, 'category_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Uts3supplier::class, 'supplier_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Uts3admin::class, 'created_by');
    }

    // public function updatedBy(): BelongsTo // Jika ada kolom updated_by
    // {
    //     return $this->belongsTo(Uts3admin::class, 'updated_by');
    // }
}
