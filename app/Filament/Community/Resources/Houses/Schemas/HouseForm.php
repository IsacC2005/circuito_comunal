<?php

namespace App\Filament\Community\Resources\Houses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('street_id')
                    ->label('Calle')
                    ->relationship('street', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('number')
                    ->label('Número')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
