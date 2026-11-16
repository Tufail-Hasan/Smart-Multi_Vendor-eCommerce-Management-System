<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('code')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('discount_type')
                    ->options(['percentage' => 'Percentage', 'fixed' => 'Fixed'])
                    ->default('percentage')
                    ->required(),
                TextInput::make('discount_value')
                    ->required()
                    ->numeric(),
                TextInput::make('maximum_discount')
                    ->numeric()
                    ->default(null),
                Select::make('applies_to')
                    ->options([
            'all_products' => 'All products',
            'specific_products' => 'Specific products',
            'specific_categories' => 'Specific categories',
            'specific_brands' => 'Specific brands',
            'specific_vendors' => 'Specific vendors',
        ])
                    ->default('all_products')
                    ->required(),
                Textarea::make('product_ids')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('category_ids')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('brand_ids')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('vendor_ids')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                TextInput::make('priority')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_combinable')
                    ->required(),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
