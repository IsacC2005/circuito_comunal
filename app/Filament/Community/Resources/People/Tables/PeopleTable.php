<?php

namespace App\Filament\Community\Resources\People\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_surname')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cedula')
                    ->label('Cédula')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Género')
                    ->badge(),
                TextColumn::make('birth_date')
                    ->label('Nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('relationship')
                    ->label('Parentesco')
                    ->badge(),
                TextColumn::make('nationality')
                    ->label('Nacionalidad')
                    ->badge(),
                TextColumn::make('academic_level')
                    ->label('Nivel educativo')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('family.house.street.name')
                    ->label('Calle')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
