<?php

namespace App\Filament\Resources;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
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

class BookingResource extends OwnedResource
{
    protected static ?string $model = Booking::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Professional';
    protected static ?string $navigationLabel = 'Bookings';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('bookable_slot_id')
                ->label('Bookable slot')
                ->relationship('bookableSlot', 'starts_at', fn (Builder $query) => $query->where('user_id', auth()->id()))
                ->searchable()
                ->preload()
                ->required()
                ->rules(fn (): array => [Rule::exists('bookable_slots', 'id')->where('user_id', auth()->id())]),
            TextInput::make('name')->label('Name')->required(),
            TextInput::make('email')->label('Email')->required(),
            Textarea::make('notes')->label('Notes'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            DateTimePicker::make('booked_at')->label('Booked at')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
            Tables\Columns\TextColumn::make('notes')->label('Notes')->searchable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->searchable()
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
            'index' => BookingResource\Pages\ListBookings::route('/')
        ];
    }
}
