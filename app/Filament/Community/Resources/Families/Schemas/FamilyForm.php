<?php

namespace App\Filament\Community\Resources\Families\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('house_id')
                    ->label('Casa')
                    ->relationship(
                        'house',
                        'number',
                        fn($query) => $query
                            ->where('community_id', Filament::getTenant()->id)
                            ->with('street')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => "#{$record->number} — {$record->street?->name}"
                            . ($record->description ? ' (' . Str::limit($record->description, 40) . ')' : '')
                    )
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

                Repeater::make('people')
                    ->label('Personas')
                    ->relationship('people')
                    ->columnSpanFull()
                    ->minItems(1)
                    ->addActionLabel('Agregar persona')
                    ->schema([
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
                            ->numeric(),

                        Select::make('gender')
                            ->label('Género')
                            ->options([
                                'masculino' => 'Masculino',
                                'femenino' => 'Femenino',
                                'otro' => 'Otro',
                            ])
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
                            ->options([
                                'venezolano' => 'Venezolano',
                                'extranjero' => 'Extranjero',
                            ])
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
                    ])
                    ->columns(2)
                    ->rules([
                        fn() => function (string $attribute, $value, $fail) {
                            $jefeCount = collect($value)->filter(
                                fn($person) => ($person['relationship'] ?? null) === 'jefe de familia'
                            )->count();

                            if ($jefeCount === 0) {
                                $fail('Debe haber al menos una persona con el parentesco "Jefe de familia".');
                            }

                            if ($jefeCount > 1) {
                                $fail('Solo puede haber un "Jefe de familia" por familia.');
                            }
                        },
                    ]),
            ]);
    }
}
