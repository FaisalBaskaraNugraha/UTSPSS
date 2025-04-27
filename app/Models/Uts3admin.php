<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uts3admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'uts3admins'; // Hubungkan dengan nama tabel

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function uts3itemsCreated(): HasMany
    {
        return $this->hasMany(Uts3item::class, 'created_by');
    }

    public function uts3categoriesCreated(): HasMany
    {
        return $this->hasMany(Uts3category::class, 'created_by');
    }

    public function uts3suppliersCreated(): HasMany
    {
        return $this->hasMany(Uts3supplier::class, 'created_by');
    }
}