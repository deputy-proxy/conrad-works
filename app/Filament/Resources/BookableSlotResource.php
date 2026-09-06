<?php

namespace App\Filament\Resources;

use App\Models\BookableSlot;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables;
use Filament\Tables\Table;

class BookableSlotResource extends Resource
{
    protected static ?string $model = BookableSlot::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Professional';
    protected static ?string $navigationLabel = 'Bookable slots';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            DateTimePicker::make('starts_at')->label('Starts at')->required(),
            DateTimePicker::make('ends_at')->label('Ends at')->required(),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            TextInput::make('type')->label('Type'),
            TextInput::make('price')->label('Price')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('starts_at')->label('Starts at')->searchable(),
            Tables\Columns\TextColumn::make('ends_at')->label('Ends at')->searchable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('Type')->searchable()
        ])->defaultSort('created_at', 'desc')->actions([
            Actions\EditAction::make(),
        ])->bulkActions([
            Actions\BulkActionGroup::make([
                Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => BookableSlotResource\Pages\ListBookableSlots::route('/')
        ];
    }
}
