<?php

namespace App\Filament\Community\Resources\People\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('family_id')
                    ->label('Familia')
                    ->relationship('family', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('first_name')
                    ->label('Primer nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('second_name')
                    ->label('Segundo nombre')
                    ->maxLength(255),
                TextInput::make('first_surname')
                    ->label('Primer apellido')
                    ->required()
                    ->maxLength(255),
                TextInput::make('second_surname')
                    ->label('Segundo apellido')
                    ->maxLength(255),
                TextInput::make('cedula')
                    ->label('Cédula')
                    ->required()
                    ->numeric()
                    ->unique(ignoreRecord: true),
                Select::make('gender')
                    ->label('Género')
                    ->options(['masculino' => 'Masculino', 'femenino' => 'Femenino', 'otro' => 'Otro'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->required()
                    ->displayFormat('d/m/Y'),
                Select::make('relationship')
                    ->label('Parentesco')
                    ->options([
                        'jefe de familia' => 'Jefe de familia',
                        'conyuge' => 'Cónyuge',
                        'hijo(a)' => 'Hijo(a)',
                        'nieto(a)' => 'Nieto(a)',
                        'otro' => 'Otro',
                    ])
                    ->required(),
                Select::make('nationality')
                    ->label('Nacionalidad')
                    ->options(['venezolano' => 'Venezolano', 'extranjero' => 'Extranjero'])
                    ->required(),
                Select::make('academic_level')
                    ->label('Nivel académico')
                    ->options([
                        'ninguno' => 'Ninguno',
                        'primaria' => 'Primaria',
                        'secundaria' => 'Secundaria',
                        'universitaria' => 'Universitaria',
                        'postgrado' => 'Postgrado',
                    ])
                    ->required(),
                Select::make('disabilities')
                    ->relationship('disabilities', 'name')
                    ->label('Discapacidad')
                    ->multiple()
                    ->preload()
            ]);
    }
}
