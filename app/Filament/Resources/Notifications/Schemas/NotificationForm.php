<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required()
                    ->default('info'),
                TextInput::make('category')
                    ->required()
                    ->default('general'),
                TextInput::make('action_url')
                    ->url()
                    ->default(null),
                DateTimePicker::make('read_at'),
                Textarea::make('data')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
