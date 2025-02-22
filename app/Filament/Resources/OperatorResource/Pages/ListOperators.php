<?php

namespace App\Filament\Resources\OperatorResource\Pages;

use App\Filament\Resources\OperatorResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListOperators extends ListRecords
{
    protected static string $resource = OperatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
