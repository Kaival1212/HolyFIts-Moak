<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('text')
                    ->required()
                    ->maxLength(255)
                    ->label('Banner Text')
                    ->placeholder('Enter the banner text')
                    ->columnSpan(2),

                TextInput::make('link')
                    ->url()
                    ->maxLength(255)
                    ->label('Banner Link')
                    ->placeholder('https://example.com')
                    ->helperText('Optional: Enter a URL for the banner to link to')
                    ->columnSpan(2),

                DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->placeholder('Select end date and time')
                    ->helperText('Optional: Set an end date for the banner')
                    ->format('Y-m-d H:i:s')
                    ->timezone('UTC'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->helperText('Toggle to activate or deactivate the banner')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('link')
                    ->searchable()
                    ->limit(30)
                    ->url(fn($record) => $record->link, true)
                    ->openUrlInNewTab()
                    ->copyable()
                    ->copyMessage('Link copied to clipboard')
                    ->copyMessageDuration(1500),

                TextColumn::make('end_date')
                    ->dateTime('M j, Y, g:i A')
                    ->sortable()
                    ->badge(),
                //->color(fn($record) => $record->end_date && $record->end_date->isPast() ? 'danger' : 'success'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
