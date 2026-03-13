<?php

namespace App\Filament\Community\Resources\Families\Pages;

use App\Filament\Community\Resources\Families\FamilyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFamilies extends ListRecords
{
    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
