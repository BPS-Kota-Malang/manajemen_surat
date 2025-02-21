<?php

namespace App\Filament\Resources\InboxResource\Pages;

use App\Filament\Resources\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditInbox extends EditRecord
{
    protected static string $resource = InboxResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $combined = $data['type'] . $data['category'];
        $randomCode = strtoupper(Str::random(5)); // Menghasilkan 5 karakter acak dalam huruf kapital
        $data['code'] = $combined . $randomCode;
        $data['status'] = 'Terkirim';
        unset($data['type'], $data['category']);

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['type'] = substr($data['code'], 0, 3);      // Ambil 3 karakter pertama
        $data['category'] = substr($data['code'], 3, 3);  // Ambil 3 karakter berikutnya
        return $data;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
