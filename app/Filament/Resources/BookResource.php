<?php

namespace App\Filament\Resources;

use App\Models\Book;
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

class BookResource extends OwnedResource
{
    protected static ?string $model = Book::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Creative';
    protected static ?string $navigationLabel = 'Books';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required(),
            TextInput::make('subtitle')->label('Subtitle'),
            Textarea::make('description')->label('Description'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            DatePicker::make('published_at')->label('Published at'),
            TextInput::make('isbn')->label('ISBN'),
            TextInput::make('cover')->label('Cover'),
            TextInput::make('url')->label('URL')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
            Tables\Columns\TextColumn::make('subtitle')->label('Subtitle')->searchable(),
            Tables\Columns\TextColumn::make('description')->label('Description')->searchable(),
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
            'index' => BookResource\Pages\ListBooks::route('/')
        ];
    }
}
