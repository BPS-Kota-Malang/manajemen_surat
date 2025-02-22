<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_inbox', 'inbox_id', 'employee_id');
    }
}

