<?php

namespace App\Filament\Community\Resources\Houses\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class FamiliesRelationManager extends RelationManager
{
    protected static string $relationship = 'families';

    protected static ?string $title = 'Familias';

    protected static ?string $modelLabel = 'Familia';

    protected static ?string $pluralModelLabel = 'Familias';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('house_status')
                    ->label('Tenencia de la vivienda')
                    ->options([
                        'propia' => 'Propia',
                        'prestada' => 'Prestada',
                        'alquilada' => 'Alquilada',
                        'hospedado' => 'Hospedado',
                        'otra' => 'Otra',
                    ])
                    ->required()
                    ->columnSpanFull(),

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
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('house_status')
                    ->label('Tenencia')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'propia' => 'success',
                        'alquilada' => 'warning',
                        'prestada' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('people_count')
                    ->label('Personas')
                    ->counts('people')
                    ->sortable(),

                TextColumn::make('people')
                    ->label('Jefe de familia')
                    ->getStateUsing(function (Model $record): string {
                        $jefe = $record->people()
                            ->where('relationship', 'jefe de familia')
                            ->first();

                        if (! $jefe) {
                            return '—';
                        }

                        return trim("{$jefe->first_name} {$jefe->first_surname}");
                    }),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
