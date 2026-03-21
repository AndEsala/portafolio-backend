<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('bio')
                    ->columnSpanFull(),
                Textarea::make('cv_url')
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Textarea::make('github_url')
                    ->columnSpanFull(),
                Textarea::make('linkedin_url')
                    ->columnSpanFull(),
                Toggle::make('is_dark_mode_default')
                    ->required(),
            ]);
    }
}
