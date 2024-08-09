<?php

namespace App\Filament\Resources\VarientResource\Pages;

use App\Filament\Resources\VarientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVarient extends EditRecord
{
    protected static string $resource = VarientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
