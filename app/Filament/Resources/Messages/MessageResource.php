<?php

namespace App\Filament\Resources\Messages;

use App\Filament\Resources\Messages\Pages\CreateMessage;
use App\Filament\Resources\Messages\Pages\EditMessage;
use App\Filament\Resources\Messages\Pages\ListMessages;
use App\Filament\Resources\Messages\Schemas\MessageForm;
use App\Filament\Resources\Messages\Tables\MessagesTable;
use App\Models\Message;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'messages';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            Section::make('Detalle del Mensaje')->schema([
                // Campos deshabilitados para que no modificar lo que me escribieron
                TextInput::make('name')
                    ->disabled()
                    ->label('Nombre del Remitente'),

                TextInput::make('email')
                    ->disabled()
                    ->label('Correo Electrónico'),

                Textarea::make('message')
                    ->disabled()
                    ->columnSpanFull()
                    ->label('Mensaje'),

                Toggle::make('is_read')
                    ->label('Marcar como leído'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ToggleColumn::make('is_read')
                ->label('Leído'),

            TextColumn::make('name')
                ->searchable()
                ->label('Remitente'),

            TextColumn::make('email')
                ->searchable()
                ->copyable() // Permite copiar el email con un clic
                ->label('Correo'),

            TextColumn::make('created_at')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->label('Recibido el'),
        ])
        ->defaultSort('created_at', 'desc')
        ->recordActions([
            EditAction::make()->label('Leer / Gestionar'),
            DeleteAction::make(), // Para borrar spam
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
