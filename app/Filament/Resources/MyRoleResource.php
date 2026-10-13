<?php
namespace App\Filament\Resources;
use App\Models\MyRole; use Filament\Forms\Components\{Select,Textarea,TextInput,Toggle}; use Filament\Resources\Resource; use Filament\Schemas\Schema; use Filament\Tables; use Filament\Tables\Table;
use Filament\Actions;
class MyRoleResource extends OwnedResource {
 protected static ?string $model=MyRole::class; protected static string|\UnitEnum|null $navigationGroup='Identity'; protected static ?string $navigationLabel='My Roles';
 public static function form(Schema $schema): Schema { return $schema->components([TextInput::make('key')->required(),TextInput::make('name')->required(),TextInput::make('article'),TextInput::make('short_description'),Textarea::make('description')->columnSpanFull(),Select::make('type')->options(['simple'=>'Simple','rich'=>'Rich'])->required(),TextInput::make('icon'),TextInput::make('image'),TextInput::make('color'),TextInput::make('sort_order')->numeric()->default(0),Toggle::make('is_active')->default(true),Toggle::make('is_featured')]); }
 public static function table(Table $table): Table { return $table->columns([Tables\Columns\TextColumn::make('name')->searchable()->sortable(),Tables\Columns\TextColumn::make('key'),Tables\Columns\TextColumn::make('type'),Tables\Columns\TextColumn::make('representativeModels_count')->counts('representativeModels')->label('Representatives'),Tables\Columns\IconColumn::make('is_active')->boolean(),Tables\Columns\IconColumn::make('is_featured')->boolean()])->defaultSort('sort_order')->actions([Actions\EditAction::make()])->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]); }
 public static function getRelations(): array { return [MyRoleResource\RelationManagers\RepresentativeModelsRelationManager::class]; }
 public static function getPages(): array { return ['index' => MyRoleResource\Pages\ListMyRoles::route('/'),'create'=>MyRoleResource\Pages\CreateMyRole::route('/create'),'edit'=>MyRoleResource\Pages\EditMyRole::route('/{record}/edit')]; }
}
