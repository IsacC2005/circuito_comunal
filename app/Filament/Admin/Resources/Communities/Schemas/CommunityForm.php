<?php

namespace App\Filament\Admin\Resources\Communities\Schemas;

use App\Models\Circuit;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommunityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('circuit_id')
                    ->label('Circuito')
                    ->relationship('circuit', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code_citur')
                    ->label('Código CITUR')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
