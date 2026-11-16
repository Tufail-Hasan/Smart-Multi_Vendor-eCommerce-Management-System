<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('subtitle')
                    ->default(null),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->required(),
                FileUpload::make('mobile_image')
                    ->image(),
                TextInput::make('alt_text')
                    ->default(null),
                TextInput::make('button_text')
                    ->default(null),
                TextInput::make('button_url')
                    ->url()
                    ->default(null),
                TextInput::make('secondary_button_text')
                    ->default(null),
                TextInput::make('secondary_button_url')
                    ->url()
                    ->default(null),
                TextInput::make('position')
                    ->required()
                    ->default('homepage'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('start_at'),
                DateTimePicker::make('end_at'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
