<?php

namespace App\Filament\Resources\Experiences;

use App\Filament\Resources\Experiences\Pages\CreateExperience;
use App\Filament\Resources\Experiences\Pages\EditExperience;
use App\Filament\Resources\Experiences\Pages\ListExperiences;
use App\Filament\Resources\Experiences\Schemas\ExperienceForm;
use App\Filament\Resources\Experiences\Tables\ExperiencesTable;
use App\Models\Experience;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'experiences';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            Section::make('Información de la Experiencia')->schema([
                Select::make('type')
                    ->options([
                        'work' => 'Experiencia Laboral',
                        'education' => 'Educación',
                    ])
                    ->required()
                    ->label('Tipo de Registro'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Cargo o Título Obtenido'),

                TextInput::make('company_or_institution')
                    ->required()
                    ->maxLength(255)
                    ->label('Empresa o Universidad'),

                DatePicker::make('start_date')
                    ->required()
                    ->label('Fecha de Inicio'),

                DatePicker::make('end_date')
                    ->label('Fecha de Fin')
                    ->helperText('Deja este campo vacío si es tu posición o estudio actual.'),

                Textarea::make('description')
                    ->columnSpanFull()
                    ->label('Descripción (Logros, tecnologías usadas, responsabilidades)'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('type')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'work' => 'success', // Verde para trabajo
                    'education' => 'info', // Azul para educación
                })
                ->formatStateUsing(fn (string $state): string => $state === 'work' ? 'Trabajo' : 'Educación')
                ->label('Tipo'),

            TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->label('Cargo / Título'),

            TextColumn::make('company_or_institution')
                ->searchable()
                ->label('Lugar'),

            TextColumn::make('start_date')
                ->date('M Y') // Ejemplo: Oct 2024
                ->sortable()
                ->label('Inicio'),

            TextColumn::make('end_date')
                ->date('M Y')
                ->default('Actualidad') // Si es nulo, mostrará "Actualidad"
                ->label('Fin'),
        ])
        ->defaultSort('start_date', 'desc') // Ordena del más reciente al más antiguo por defecto
        ->recordActions([
            EditAction::make(),
        ])
        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
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
            'index' => ListExperiences::route('/'),
            'create' => CreateExperience::route('/create'),
            'edit' => EditExperience::route('/{record}/edit'),
        ];
    }
}
