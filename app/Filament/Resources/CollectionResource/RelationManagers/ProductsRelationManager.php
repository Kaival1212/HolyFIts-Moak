<?php

namespace App\Filament\Resources\CollectionResource\RelationManagers;

use App\Models\Collection;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'Products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                TextInput::make('image')
                    ->label('Image URL')
                    ->url()
                    ->required(),
                Checkbox::make('is_active')
                    ->label('Is Active')
                    ->default(false),
                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->minLength(100),
                Select::make('collection_id')
                    ->label('Collection')
                    ->options(Collection::all()->pluck('name', 'id'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Products')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('collection.name')->sortable()->searchable(),
                TextColumn::make('cheapest_varient')
                    ->label('Cheapest Varient Price')
                    ->numeric()
                    ->prefix('$')
                    ->getStateUsing(function ($record) {
                        return $record->getCheapestVarient();
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
