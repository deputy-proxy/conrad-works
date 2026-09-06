<?php

namespace App\Filament\Resources;

use App\Models\Course;
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

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Professional';
    protected static ?string $navigationLabel = 'Courses';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required(),
            Textarea::make('description')->label('Description'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            TextInput::make('duration')->label('Duration'),
            TextInput::make('price')->label('Price'),
            TextInput::make('audience')->label('Audience'),
            TextInput::make('image')->label('Image')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
            Tables\Columns\TextColumn::make('description')->label('Description')->searchable(),
            Tables\Columns\TextColumn::make('status')->label('Status')->searchable(),
            Tables\Columns\TextColumn::make('duration')->label('Duration')->searchable()
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
            'index' => CourseResource\Pages\ListCourses::route('/')
        ];
    }
}
