<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function inboxes()
    {
        return $this->belongsToMany(Inbox::class, 'employee_inbox', 'employee_id', 'inbox_id');
    }
}

