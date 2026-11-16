<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Vendor & Product Classification')
                ->description('Select the vendor, category and brand for this product.')
                ->icon('heroicon-o-building-storefront')
                ->columns(3)
                ->schema([
                    Select::make('vendor_id')
                        ->label('Vendor')
                        ->options(fn () => Vendor::query()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('category_id')
                        ->label('Category')
                        ->options(fn () => Category::query()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('brand_id')
                        ->label('Brand')
                        ->options(fn () => Brand::query()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->nullable(),
                ]),

            Section::make('Basic Product Information')
                ->icon('heroicon-o-shopping-bag')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Product Name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            if (blank($get('slug'))) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }
                        }),

                    TextInput::make('slug')
                        ->label('Product Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(
                            table: 'products',
                            column: 'slug',
                            ignoreRecord: true
                        ),

                    TextInput::make('sku')
                        ->label('SKU')
                        ->required()
                        ->maxLength(255)
                        ->unique(
                            table: 'products',
                            column: 'sku',
                            ignoreRecord: true
                        ),

                    TextInput::make('color')
                        ->label('Color')
                        ->maxLength(255),

                    TextInput::make('size')
                        ->label('Size')
                        ->maxLength(255),

                    Textarea::make('short_description')
                        ->label('Short Description')
                        ->maxLength(500)
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Full Description')
                        ->rows(6)
                        ->columnSpanFull(),
                ]),

            Section::make('Pricing & Inventory')
                ->icon('heroicon-o-currency-dollar')
                ->columns(3)
                ->schema([
                    TextInput::make('price')
                        ->label('Regular Price')
                        ->numeric()
                        ->prefix('৳')
                        ->required()
                        ->minValue(0),

                    TextInput::make('discount_price')
                        ->label('Discount Price')
                        ->numeric()
                        ->prefix('৳')
                        ->nullable()
                        ->minValue(0),

                    TextInput::make('cost_price')
                        ->label('Cost Price')
                        ->numeric()
                        ->prefix('৳')
                        ->nullable()
                        ->minValue(0),

                    TextInput::make('stock')
                        ->label('Available Stock')
                        ->numeric()
                        ->integer()
                        ->required()
                        ->default(0)
                        ->minValue(0),

                    TextInput::make('low_stock_threshold')
                        ->label('Low Stock Alert')
                        ->numeric()
                        ->integer()
                        ->required()
                        ->default(5)
                        ->minValue(0),

                    TextInput::make('weight')
                        ->label('Product Weight')
                        ->numeric()
                        ->nullable()
                        ->minValue(0),

                    Select::make('weight_unit')
                        ->label('Weight Unit')
                        ->options([
                            'kg' => 'Kilogram (kg)',
                            'g' => 'Gram (g)',
                            'lb' => 'Pound (lb)',
                            'oz' => 'Ounce (oz)',
                        ])
                        ->default('kg')
                        ->required(),
                ]),

            Section::make('Product Images')
                ->description('Upload the main product image and additional gallery images.')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->schema([
                    FileUpload::make('thumbnail')
                        ->label('Product Thumbnail')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->nullable(),

                    FileUpload::make('gallery')
                        ->label('Product Gallery')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->directory('products/gallery')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->reorderable()
                        ->nullable(),
                ]),

            Section::make('Publication & Approval')
                ->icon('heroicon-o-check-badge')
                ->columns(2)
                ->schema([
                    Select::make('status')
                        ->label('Product Status')
                        ->options([
                            'draft' => 'Draft',
                            'pending_review' => 'Pending Review',
                            'published' => 'Published',
                            'rejected' => 'Rejected',
                            'inactive' => 'Inactive',
                        ])
                        ->default('pending_review')
                        ->required(),

                    Toggle::make('is_featured')
                        ->label('Featured Product')
                        ->default(false),

                    Toggle::make('is_approved')
                        ->label('Admin Approved')
                        ->default(false),

                    DateTimePicker::make('published_at')
                        ->label('Publication Date')
                        ->seconds(false)
                        ->nullable(),
                ]),

            Section::make('SEO Information')
                ->description('Optional search engine optimization fields.')
                ->icon('heroicon-o-magnifying-glass')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(255)
                        ->nullable(),

                    Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(3)
                        ->columnSpanFull()
                        ->nullable(),
                ]),
        ]);
    }
}
