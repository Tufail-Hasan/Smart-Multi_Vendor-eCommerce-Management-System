<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
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
                TextInput::make('minimum_order_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('usage_limit')
                    ->numeric()
                    ->default(null),
                TextInput::make('usage_limit_per_customer')
                    ->numeric()
                    ->default(null),
                TextInput::make('used_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('applies_to')
                    ->options([
            'all' => 'All',
            'specific_products' => 'Specific products',
            'specific_categories' => 'Specific categories',
            'specific_vendors' => 'Specific vendors',
        ])
                    ->default('all')
                    ->required(),
                Textarea::make('product_ids')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('category_ids')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('vendor_ids')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('expires_at'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('currency')
                    ->required()
                    ->default('BDT'),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                Textarea::make('admin_note')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
