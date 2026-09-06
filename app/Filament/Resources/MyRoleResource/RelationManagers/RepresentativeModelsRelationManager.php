<?php
namespace App\Filament\Resources\MyRoleResource\RelationManagers;
use App\Support\RoleRepresentativeModels; use Filament\Forms\Components\{Select,TextInput,Toggle}; use Filament\Resources\RelationManagers\RelationManager; use Filament\Schemas\Schema; use Filament\Tables; use Filament\Tables\Table;
use Filament\Actions;
class RepresentativeModelsRelationManager extends RelationManager {
 protected static string $relationship='representativeModels'; protected static ?string $title='Representative Models';
 public function form(Schema $schema): Schema { return $schema->components([Select::make('model_type')->label('Model')->options(RoleRepresentativeModels::options())->required()->searchable(),TextInput::make('label'),TextInput::make('icon'),TextInput::make('sort_order')->numeric()->default(0),Toggle::make('is_primary')]); }
 public function table(Table $table): Table { return $table->recordTitleAttribute('model_type')->columns([Tables\Columns\TextColumn::make('model_type')->formatStateUsing(fn($state)=>RoleRepresentativeModels::options()[$state]??$state),Tables\Columns\TextColumn::make('label'),Tables\Columns\TextColumn::make('sort_order'),Tables\Columns\IconColumn::make('is_primary')->boolean()])->defaultSort('sort_order')->headerActions([Actions\CreateAction::make()])->actions([Actions\EditAction::make(),Actions\DeleteAction::make()]); }
}
