<?php

namespace App\Filament\Resources;

use App\Models\WifeMessage;
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

class WifeMessageResource extends Resource
{
    protected static ?string $model = WifeMessage::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Personal';
    protected static ?string $navigationLabel = 'Wife messages';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required(),
            Textarea::make('message')->label('Message')->required(),
            TextInput::make('type')->label('Type'),
            DatePicker::make('message_date')->label('Date'),
            DateTimePicker::make('delivered_at')->label('Delivered at')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
            Tables\Columns\TextColumn::make('message')->label('Message')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('Type')->searchable(),
            Tables\Columns\TextColumn::make('message_date')->label('Date')->searchable()
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
            'index' => WifeMessageResource\Pages\ListWifeMessages::route('/')
        ];
    }
}
