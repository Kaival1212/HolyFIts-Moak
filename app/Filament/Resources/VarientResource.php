<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VarientResource\Pages;
use App\Filament\Resources\VarientResource\RelationManagers;
use App\Models\Varient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VarientResource extends Resource
{
    protected static ?string $model = Varient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('attributes')->required(),
                Forms\Components\Checkbox::make('is_active')->required(),
                Forms\Components\TextInput::make('price')->numeric()->required(),
                Forms\Components\TextInput::make('image')->url()->required(),
                Forms\Components\TextInput::make('stock')->numeric()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('attributes')->searchable()->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('stock')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('price')->numeric()->prefix('$')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVarients::route('/'),
            'create' => Pages\CreateVarient::route('/create'),
            'edit' => Pages\EditVarient::route('/{record}/edit'),
        ];
    }
}
