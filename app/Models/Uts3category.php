<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uts3category extends Model
{
    use HasFactory;

    protected $table = 'uts3categories'; // Hubungkan dengan nama tabel

    protected $fillable = [
        'name', 'description', 'created_by',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Uts3admin::class, 'created_by');
    }

    public function uts3items(): HasMany
    {
        return $this->hasMany(Uts3item::class, 'category_id');
    }
}