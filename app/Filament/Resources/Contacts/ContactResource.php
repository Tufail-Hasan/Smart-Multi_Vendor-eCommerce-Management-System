<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Contacts\Pages;
use App\Models\Contact;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $modelLabel = 'Contact Message';

    protected static ?string $pluralModelLabel = 'Contact Messages';

    protected static string|\UnitEnum|null $navigationGroup = 'Contact Management';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Customer Name')
                    ->disabled(),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->disabled(),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->disabled(),

                TextInput::make('subject')
                    ->label('Subject')
                    ->disabled(),

                Textarea::make('message')
                    ->label('Customer Message')
                    ->rows(7)
                    ->disabled()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Message Status')
                    ->options([
                        'unread' => 'Unread',
                        'read' => 'Read',
                        'replied' => 'Replied',
                    ])
                    ->required()
                    ->native(false),

                DateTimePicker::make('replied_at')
                    ->label('Replied At')
                    ->seconds(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unread' => 'danger',
                        'read' => 'warning',
                        'replied' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'unread' => 'heroicon-m-envelope',
                        'read' => 'heroicon-m-envelope-open',
                        'replied' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'unread' => 'Unread',
                        'read' => 'Read',
                        'replied' => 'Replied',
                    ]),

            ])

            ->recordActions([

                ViewAction::make()
                    ->label('View'),

                Action::make('markAsRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-m-envelope-open')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Contact $record): void {
                        $record->update([
                            'status' => 'read',
                        ]);
                    })
                    ->visible(fn (Contact $record): bool =>
                        $record->status === 'unread'
                    ),

                EditAction::make()
                    ->label('Update Status'),

                DeleteAction::make()
                    ->label('Delete')
                    ->requiresConfirmation(),

            ])

            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
