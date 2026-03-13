<?php

namespace App\Filament\Community\Resources\Streets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StreetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de la calle')
                    ->required()
                    ->maxLength(255),
                Select::make('leader_id')
                    ->label('Líder de calle')
                    ->relationship('leader', 'first_name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }
}
