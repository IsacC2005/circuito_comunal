<?php

namespace App\Filament\Community\Resources\People\Pages;

use App\Filament\Community\Resources\People\PersonResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerson extends EditRecord
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
