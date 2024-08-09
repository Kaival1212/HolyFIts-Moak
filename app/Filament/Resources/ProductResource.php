<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\VarientsRelationManager;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Tag;
use Faker\Provider\Text;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
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
                Forms\Components\TagsInput::make('tags')->prefix('#'),

                MarkdownEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->minLength(100),

                Select::make('collection_id')
                    ->label('Collection')
                    ->options(Collection::all()->pluck('name', 'id'))
                    ->required(),

                Forms\Components\Repeater::make('varients')->relationship('varients')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('attributes')->required(),
                    Forms\Components\Checkbox::make('is_active'),
                    Forms\Components\TextInput::make('price')->numeric()->required(),
                    Forms\Components\TextInput::make('image')->url()->required(),
                    Forms\Components\TextInput::make('stock')->numeric()->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            VarientsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
