<?php

namespace App\Filament\Resources;

use App\Models\Venture;
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

class VentureResource extends Resource
{
    protected static ?string $model = Venture::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Professional';
    protected static ?string $navigationLabel = 'Ventures';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            TextInput::make('slug')->label('Slug')->required(),
            Textarea::make('description')->label('Description'),
            TextInput::make('url')->label('URL'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            TextInput::make('type')->label('Type'),
            DatePicker::make('started_at')->label('Started at'),
            DatePicker::make('ended_at')->label('Ended at'),
            Toggle::make('featured')->label('Featured')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
            Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
            Tables\Columns\TextColumn::make('description')->label('Description')->searchable(),
            Tables\Columns\TextColumn::make('url')->label('URL')->searchable()
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
            'index' => VentureResource\Pages\ListVentures::route('/')
        ];
    }
}
