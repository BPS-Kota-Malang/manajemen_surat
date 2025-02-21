<?php

namespace App\Filament\Resources\InboxResource\Pages;

use App\Filament\Resources\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateInbox extends CreateRecord
{
    protected static string $resource = InboxResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Menggabungkan nilai dari select option 'type' dan 'category'
        $combined = $data['type'] . $data['category'];
        $randomCode = strtoupper(Str::random(5)); // Menghasilkan 5 karakter acak dalam huruf kapital
        $data['code'] = $combined . $randomCode;

        // Set status secara default
        $data['status'] = 'Terkirim';

        // Hapus field temporary 'type' dan 'category' jika tidak ingin disimpan di database
        unset($data['type'], $data['category']);

        return $data;
    }
}
