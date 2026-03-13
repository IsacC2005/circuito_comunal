<?php

namespace App\Filament\Community\Resources\Houses\Pages;

use App\Filament\Community\Resources\Houses\HouseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHouse extends EditRecord
{
    protected static string $resource = HouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
