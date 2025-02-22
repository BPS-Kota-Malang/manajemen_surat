<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OperatorResource\Pages;
use App\Models\Operator;
use App\Models\User;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Support\Facades\DB;

class OperatorResource extends Resource
{
    protected static ?string $model = Operator::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOperators::route('/'),
            'create' => Pages\CreateOperator::route('/create'),
            'edit' => Pages\EditOperator::route('/{record}/edit'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('user.username')->label('Username'),
                Columns\TextColumn::make('user.name')->label('Nama'),
                Columns\TextColumn::make('user.no_tlp')->label('No. Telepon'),
                Columns\TextColumn::make('number')->label('Nomor Operator'),
                Columns\TextColumn::make('address')->label('Alamat'),
                Columns\TextColumn::make('gender')->label('Jenis Kelamin')
                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                Columns\TextColumn::make('position')->label('Posisi'),
                Columns\TextColumn::make('email')->label('Email'),
                Columns\TextColumn::make('user.role.role')->label('Role'),
            ])
            ->actions([
                EditAction::make()->label('Edit'),
                DeleteAction::make()
                ->label('Hapus')
                ->before(function ($record) {
                    if ($record->user) {
                        $record->user->delete(); // Hapus user yang terkait sebelum operator dihapus
                    }
                }),
            ])
            ->headerActions([
                ExportAction::make()->label('Ekspor')
                    ->formats(['csv', 'xlsx', 'pdf']),
                ImportAction::make()->label('Impor')
            ])
            ->filters([]);
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('username')
                ->label('Username')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('number')
                ->label('Nomor Operator')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('no_tlp')
                ->label('Nomor Telepon')
                ->required()
                ->maxLength(15) // panjang nomor telepon

                ->numeric() // hanya angka yang dapat dimasukkan

                ->unique(User::class, 'no_tlp'), // nomor tidak duplikat

            Forms\Components\TextInput::make('address')
                ->label('Alamat')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('gender')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            Forms\Components\TextInput::make('position')
                ->label('Posisi')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email()
                ->unique(Operator::class, 'email'),

            Forms\Components\Select::make('role_id')
                ->label('Role')
                ->options(fn () => Role::pluck('role', 'role_id'))
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\Hidden::make('user_id'),
        ]);
}

}
