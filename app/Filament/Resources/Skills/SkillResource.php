<?php

namespace App\Filament\Resources\Skills;

use App\Filament\Resources\Skills\Pages\CreateSkill;
use App\Filament\Resources\Skills\Pages\EditSkill;
use App\Filament\Resources\Skills\Pages\ListSkills;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use App\Filament\Resources\Skills\Tables\SkillsTable;
use App\Models\Skill;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'skills';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            Section::make('Detalles de la Habilidad')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre (Ej. Laravel, React)'),

                TextInput::make('category')
                    ->required()
                    ->maxLength(255)
                    ->default('General')
                    ->datalist([
                        'Backend',
                        'Frontend',
                        'Base de Datos',
                        'Infraestructura',
                        'Herramientas'
                    ])
                    ->label('Categoría'),

                TextInput::make('icon')
                    ->maxLength(255)
                    ->label('Clase del Icono (Ej. devicon-laravel-plain) o URL'),

                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Orden de aparición'),

                Toggle::make('is_visible')
                    ->default(true)
                    ->label('¿Visible en el portafolio?'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Nombre'),

            TextColumn::make('category')
                ->searchable()
                ->sortable()
                ->badge() // Lo muestra como una etiqueta visual agradable
                ->label('Categoría'),

            TextColumn::make('order')
                ->sortable()
                ->label('Orden'),

            IconColumn::make('is_visible')
                ->boolean()
                ->label('Visible'),
        ])
        ->filters([
            // Aquí puedes agregar filtros más adelante si lo deseas
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
            'index' => ListSkills::route('/'),
            'create' => CreateSkill::route('/create'),
            'edit' => EditSkill::route('/{record}/edit'),
        ];
    }
}
