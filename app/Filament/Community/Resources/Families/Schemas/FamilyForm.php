<?php

namespace App\Filament\Community\Resources\Families\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('house_id')
                    ->label('Casa')
                    ->relationship('house', 'number')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('house_status')
                    ->label('Tenencia de la vivienda')
                    ->options([
                        'propia' => 'Propia',
                        'prestada' => 'Prestada',
                        'alquilada' => 'Alquilada',
                        'hospedado' => 'Hospedado',
                        'otra' => 'Otra',
                    ])
                    ->required(),
                TextInput::make('food_module')
                    ->label('Módulo alimentario')
                    ->numeric()
                    ->nullable(),
                TextInput::make('gas_cylinder')
                    ->label('Bombonas de gas')
                    ->numeric()
                    ->nullable(),
            ]);
    }
}
