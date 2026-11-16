<?php

namespace App\Filament\Resources\OrderStatuses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                TextInput::make('previous_status')
                    ->default(null),
                TextInput::make('status')
                    ->required(),
                TextInput::make('changed_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('comment')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('changed_at')
                    ->required(),
            ]);
    }
}
