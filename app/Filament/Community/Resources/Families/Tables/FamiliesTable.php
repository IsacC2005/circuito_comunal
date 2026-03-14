<?php

namespace App\Filament\Community\Resources\Families\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FamiliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('house.street.name')
                    ->label('Calle')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('house.number')
                    ->label('Casa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('house_status')
                    ->label('Tenencia')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'propia' => 'success',
                        'alquilada' => 'warning',
                        'prestada' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('food_modules_total')
                    ->label('Mód. alimentario')
                    ->sum('foodModules as food_modules_total', 'family_food_module.count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gas_cylinders_total')
                    ->label('Bombonas')
                    ->sum('gasCilinders as gas_cylinders_total', 'family_gas_cilinder.count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('people_count')
                    ->label('Personas')
                    ->counts('people')
                    ->sortable(),
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
