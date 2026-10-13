<?php

namespace App\Filament\Resources;

use App\Models\Habit;
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

class HabitResource extends OwnedResource
{
    protected static ?string $model = Habit::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Personal';
    protected static ?string $navigationLabel = 'Habits';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('description')->label('Description'),
            TextInput::make('frequency')->label('Frequency')->required(),
            TextInput::make('target')->label('Target'),
            DatePicker::make('start_date')->label('Start date'),
            DatePicker::make('end_date')->label('End date'),
            Toggle::make('active')->label('Active')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
            Tables\Columns\TextColumn::make('description')->label('Description')->searchable(),
            Tables\Columns\TextColumn::make('frequency')->label('Frequency')->searchable(),
            Tables\Columns\TextColumn::make('target')->label('Target')->searchable()
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
            'index' => HabitResource\Pages\ListHabits::route('/'),
            'create' => HabitResource\Pages\CreateHabit::route('/create'),
            'edit' => HabitResource\Pages\EditHabit::route('/{record}/edit'),
        ];
    }
}
