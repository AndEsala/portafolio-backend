<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'projects';

    public static function form(Schema $schema): Schema
    {
        return $schema
        ->schema([
            Section::make('Información Principal')->schema([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->label('Título del Proyecto'),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('URL Amigable (Slug)'),

                Textarea::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('Descripción Breve'),

                RichEditor::make('content')
                    ->columnSpanFull()
                    ->label('Contenido / Detalle (Opcional)'),
            ])->columns(2),

            Section::make('Multimedia y Enlaces')->schema([
                FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
                    ->label('Imagen de Previsualización'),

                Select::make('skills')
                    ->multiple()
                    ->relationship('skills', 'name')
                    ->preload()
                    ->label('Tecnologías Utilizadas'),

                TextInput::make('github_url')
                    ->url()
                    ->label('URL del Repositorio'),

                TextInput::make('demo_url')
                    ->url()
                    ->label('URL de la Demo'),
            ])->columns(2),

            Section::make('Configuración')->schema([
                Toggle::make('is_featured')
                    ->label('¿Destacar en el inicio?')
                    ->default(false),

                TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Orden de aparición'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ImageColumn::make('image_path')
                ->circular()
                ->label('Imagen'),

            TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->label('Título'),

            // Muestra las tecnologías asociadas como "etiquetas" (badges)
            TextColumn::make('skills.name')
                ->badge()
                ->separator(',')
                ->label('Tecnologías'),

            // Un ToggleColumn permite cambiar el estado directamente desde la tabla sin entrar a editar
            ToggleColumn::make('is_featured')
                ->label('Destacado'),

            TextColumn::make('order')
                ->sortable()
                ->label('Orden'),
        ])
        ->filters([
            TernaryFilter::make('is_featured')
                ->label('Solo Destacados'),
        ])
        ->recordActions([
            EditAction::make(),
        ])
        ->toolbarActions([
            DeleteBulkAction::make(),
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
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
