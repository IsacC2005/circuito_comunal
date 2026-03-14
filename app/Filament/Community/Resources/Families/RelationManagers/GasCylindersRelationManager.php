<?php

namespace App\Filament\Community\Resources\Families\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GasCylindersRelationManager extends RelationManager
{
    protected static string $relationship = 'gasCylinders';

    protected static ?string $title = 'Bonbonas de Gas';

    protected static ?string $modelLabel = 'Bombona';

    protected static ?string $pluralModelLabel = 'Bonbonas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('count')
                    ->label('Cantidad')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')
                    ->label('Empresa')
                    ->sortable(),

                TextColumn::make('size')
                    ->label('Tamaño (kg)')
                    ->sortable(),

                TextColumn::make('typeConnection.name')
                    ->label('Tipo conexión')
                    ->sortable(),

                TextColumn::make('count')
                    ->label('Cantidad')
                    ->getStateUsing(fn(Model $record): int => $record->pivot->count),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Agregar bombona')
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(
                        fn($query) => $query->with(['company', 'typeConnection'])
                    )
                    ->recordSelectSearchColumns(['size'])
                    ->recordTitle(
                        fn(Model $record): string => "{$record->company->name} – {$record->size} kg – {$record->typeConnection->name}"
                    )
                    ->schema(fn(AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('count')
                            ->label('Cantidad')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->form([
                        TextInput::make('count')
                            ->label('Cantidad')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ]),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
