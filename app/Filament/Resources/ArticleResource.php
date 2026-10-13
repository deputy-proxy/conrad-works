<?php

namespace App\Filament\Resources;

use App\Models\Article;
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

class ArticleResource extends OwnedResource
{
    protected static ?string $model = Article::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Creative';
    protected static ?string $navigationLabel = 'Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Title')->required(),
            TextInput::make('slug')->label('Slug')->required(),
            Textarea::make('excerpt')->label('Excerpt'),
            RichEditor::make('body')->label('Body'),
            DateTimePicker::make('published_at')->label('Published at'),
            Select::make('status')->label('Status')->options(['draft' => 'Draft', 'active' => 'Active', 'available' => 'Available', 'booked' => 'Booked', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'published' => 'Published']),
            TextInput::make('publication')->label('Publication'),
            TextInput::make('url')->label('URL')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
            Tables\Columns\TextColumn::make('slug')->label('Slug')->searchable(),
            Tables\Columns\TextColumn::make('excerpt')->label('Excerpt')->searchable(),
            Tables\Columns\TextColumn::make('body')->label('Body')->searchable()
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
            'index' => ArticleResource\Pages\ListArticles::route('/'),
            'create' => ArticleResource\Pages\CreateArticle::route('/create'),
            'edit' => ArticleResource\Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
