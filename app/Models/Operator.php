<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators'; // Nama tabel di database
    protected $primaryKey = 'operator_id'; // Primary key tabel
    public $incrementing = true; // Jika auto-increment, biarkan true
    protected $keyType = 'int'; // Tipe data primary key

    protected $fillable = [
        'number',
        'address',
        'gender',
        'position',
        'email',
        'user_id',
    ];

    /**
     * Relasi ke tabel users
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}