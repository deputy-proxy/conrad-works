<?php

namespace App\Filament\Resources;

use App\Models\HabitCompletion;
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

class HabitCompletionResource extends OwnedResource
{
    protected static ?string $model = HabitCompletion::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Creative';
    protected static ?string $navigationLabel = 'Habit completions';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('habit_id')
                ->label('Habit')
                ->relationship('habit', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->rules([Rule::exists('habits', 'id')]),
            DatePicker::make('completed_on')->label('Completed on')->required(),
            Textarea::make('notes')->label('Notes')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('habit_id')->label('Habit ID')->searchable(),
            Tables\Columns\TextColumn::make('completed_on')->label('Completed on')->searchable(),
            Tables\Columns\TextColumn::make('notes')->label('Notes')->searchable()
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
            'index' => HabitCompletionResource\Pages\ListHabitCompletions::route('/'),
            'create' => HabitCompletionResource\Pages\CreateHabitCompletion::route('/create'),
            'edit' => HabitCompletionResource\Pages\EditHabitCompletion::route('/{record}/edit'),
        ];
    }
}
