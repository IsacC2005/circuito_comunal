<?php

namespace App\Filament\Admin\Resources\Circuits;

use App\Filament\Admin\Resources\Circuits\Pages\CreateCircuit;
use App\Filament\Admin\Resources\Circuits\Pages\EditCircuit;
use App\Filament\Admin\Resources\Circuits\Pages\ListCircuits;
use App\Filament\Admin\Resources\Circuits\Schemas\CircuitForm;
use App\Filament\Admin\Resources\Circuits\Tables\CircuitsTable;
use App\Models\Circuit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CircuitResource extends Resource
{
    protected static ?string $model = Circuit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Circuito';

    protected static ?string $pluralModelLabel = 'Circuitos';

    protected static \UnitEnum|string|null $navigationGroup = 'Estructura Territorial';

    public static function form(Schema $schema): Schema
    {
        return CircuitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CircuitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCircuits::route('/'),
            'create' => CreateCircuit::route('/create'),
            'edit' => EditCircuit::route('/{record}/edit'),
        ];
    }
}
