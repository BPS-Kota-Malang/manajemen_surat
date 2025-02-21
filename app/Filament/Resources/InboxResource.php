<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InboxResource\Pages;
use App\Filament\Resources\InboxResource\RelationManagers;
use App\Models\Employee;
use App\Models\Inbox;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Select;

class InboxResource extends Resource
{
    protected static ?string $model = Inbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sender')
                    ->label('Sender')
                    ->required(),

                DatePicker::make('date')
                    ->label('Date')
                    ->required(),

                Select::make('type')
                    ->label('Letter Type')
                    ->options([
                        '001' => 'Surat Keputusan',
                        '002' => 'Surat Undangan',
                        '003' => 'Surat Permohonan',
                        '008' => 'Surat Tugas',
                    ])
                    ->required(),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        '123' => 'Resmi',
                        '213' => 'Dinas',
                        '321' => 'Pribadi',
                    ])
                    ->required(),

                TextInput::make('subject')
                    ->label('Subject')
                    ->required(),

                Select::make('employee_id')
                    ->multiple()
                    ->label('Related Employee')
                    ->options(
                        \App\Models\Employee::join('users', 'employees.user_id', '=', 'users.user_id')
                            ->pluck('users.name', 'employees.employee_id')
                    ),

                Select::make('operator_id')
                    ->label('Operator')
                    ->options(
                        \App\Models\Operator::join('users', 'operators.user_id', '=', 'users.user_id')
                            ->pluck('users.name', 'operators.operator_id')
                    ),

                // Membungkus FileUpload dan TextArea dalam Grid 1 kolom
                Grid::make(1)
                    ->schema([
                        FileUpload::make('file')
                            ->label('Lampiran')
                            ->directory('inbox-files')
                            ->nullable(),

                        TextArea::make('content')
                            ->label('Isi Surat')
                            ->required(),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inbox_id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('sender')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date() // format default Y-m-d
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Kode')
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Perihal')
                    ->limit(20), // batasi tampilan

                // Jika ingin menampilkan potongan isi content:
                // TextColumn::make('content')->limit(50)

                // Tampilkan file sebagai link atau icon
                // misalnya:
                // IconColumn::make('file')->boolean()
                // atau
                // TextColumn::make('file')->label('File')->limit(10)

                TextColumn::make('operator.user.name')
                    ->label('Operator'),


                // dsb
            ])
            ->filters([
                // Anda dapat menambahkan filter di sini
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInboxes::route('/'),
            'create' => Pages\CreateInbox::route('/create'),
            'edit' => Pages\EditInbox::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        // return auth()->user()->can('create', Inbox::class);
        return true;
    }

    public static function canDeleteAny(): bool
    {
        return true;
    }
}
