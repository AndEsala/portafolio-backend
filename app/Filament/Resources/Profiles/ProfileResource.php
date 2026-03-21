<?php

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\CreateProfile;
use App\Filament\Resources\Profiles\Pages\EditProfile;
use App\Filament\Resources\Profiles\Pages\ListProfiles;
use App\Filament\Resources\Profiles\Schemas\ProfileForm;
use App\Filament\Resources\Profiles\Tables\ProfilesTable;
use App\Models\Profile;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'profiles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
            Section::make('Información Personal')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre Completo'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Cargo / Titular (Ej. Software Developer)'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Correo de Contacto'),

                Textarea::make('bio')
                    ->columnSpanFull()
                    ->label('Biografía (Hero Section)'),
            ])->columns(2),

            Section::make('Enlaces y Currículum')->schema([
                FileUpload::make('avatar')
                    ->image()
                    ->directory('avatars')
                    ->disk('public')
                    ->label('Foto de Perfil'),

                TextInput::make('github_url')
                    ->url()
                    ->label('Perfil de GitHub'),

                TextInput::make('linkedin_url')
                    ->url()
                    ->label('Perfil de LinkedIn'),

                // Subida del CV asegurándonos de que vaya al disco público y sea PDF
                FileUpload::make('cv_url')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('cv')
                    ->disk('public')
                    ->label('Hoja de Vida (PDF)'),
            ])->columns(2),

            Section::make('Preferencias Visuales')->schema([
                Toggle::make('is_dark_mode_default')
                    ->label('¿Modo Oscuro por defecto en el portafolio?')
                    ->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')->label('Nombre'),
            TextColumn::make('title')->label('Cargo'),
            TextColumn::make('email')->label('Correo'),
            TextColumn::make('updated_at')
                ->dateTime('d/m/Y H:i')
                ->label('Última actualización'),
        ])
        ->recordActions([
            EditAction::make()->label('Actualizar Perfil'),
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
            'index' => ListProfiles::route('/'),
            'create' => CreateProfile::route('/create'),
            'edit' => EditProfile::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // 2. Prevenir que se pueda borrar tu único perfil
    public static function canDelete(?Model $record): bool
    {
        return false;
    }
}
