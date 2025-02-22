<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Pastikan nama tabel benar
    protected $primaryKey = 'role_id'; // Pastikan primary key benar

    protected $fillable = ['role'];
}
