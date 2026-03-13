<?php

namespace App\Filament\Community\Resources\People\Pages;

use App\Filament\Community\Resources\People\PersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;
}
