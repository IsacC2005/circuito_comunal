<?php

namespace App\Filament\Community\Resources\Streets\Pages;

use App\Filament\Community\Resources\Streets\StreetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStreet extends EditRecord
{
    protected static string $resource = StreetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
