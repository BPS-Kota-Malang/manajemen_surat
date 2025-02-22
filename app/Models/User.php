<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'user_id'; // Menggunakan primary key yang benar

    protected $fillable = [
        'username',
        'password',
        'name',
        'no_tlp',
        'photourl',
        'role_id',
    ];

    // 1 User memiliki 1 Operator (One-to-One)
    public function operator(): HasOne
    {
        return $this->hasOne(Operator::class, 'user_id');
    }

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }
}
