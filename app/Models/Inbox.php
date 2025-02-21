<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Inbox extends Model
{

    protected $table = 'inbox';
    protected $primaryKey = 'inbox_id'; // Jika primary key Anda bukan 'id'

    // Kolom-kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'sender',
        'date',
        'status',
        'code',
        'subject',
        'content',
        'file',
        'employee_id', // jika disimpan dalam bentuk JSON
        'operator_id'
    ];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = $data['type'] . $data['category'];
        $data['status'] = 'Terkirim';
        unset($data['type'], $data['category']);
        return $data;
    }
    // protected static function booted()
    // {
    //     static::creating(function ($inbox) {            
    //         if (isset($inbox->type, $inbox->category)) {
    //             $combined = $inbox->type . $inbox->category;
    //             $randomCode = strtoupper(Str::random(5));
    //             $inbox->code = $combined;
    //         }
    //         $inbox->status = 'Terkirim';
    //     });
    // }

    // Jika employee_id disimpan sebagai JSON, aktifkan cast ke array/collection
    protected $casts = [
        'employee_id' => 'array', // atau 'json'
    ];

    // Contoh relasi (jika operator disimpan di tabel 'operators')
    // public function operator()
    // {
    //     return $this->belongsTo(Operator::class, 'operator_id');
    // }

    // Jika memilih many-to-many (opsional):
    // public function employees()
    // {
    //     return $this->belongsToMany(Employee::class, 'employee_inbox', 'inbox_id', 'employee_id');
    // }
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'operator_id');
    }
}
