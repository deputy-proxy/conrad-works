<?php

namespace App\Filament\Resources;

use App\Models\Song;
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

class SongResource extends OwnedResource
{
    protected static ?string $model = Song::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Creative';
    protected static ?string $navigationLabel = 'Songs';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required(),
            RichEditor::make('lyrics')->label('Lyrics'),
            Textarea::make('description')->label('Description'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            DatePicker::make('written_at')->label('Written at'),
            TextInput::make('recording')->label('Recording'),
            TextInput::make('audio')->label('Audio'),
            TextInput::make('cover')->label('Cover')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
            Tables\Columns\TextColumn::make('lyrics')->label('Lyrics')->searchable(),
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
            'index' => SongResource\Pages\ListSongs::route('/')
        ];
    }
}
