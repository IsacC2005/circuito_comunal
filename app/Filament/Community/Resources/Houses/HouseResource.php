<?php

namespace App\Filament\Community\Resources\Houses;

use App\Filament\Community\Resources\Houses\Pages\CreateHouse;
use App\Filament\Community\Resources\Houses\Pages\EditHouse;
use App\Filament\Community\Resources\Houses\Pages\ListHouses;
use App\Filament\Community\Resources\Houses\RelationManagers\FamiliesRelationManager;
use App\Filament\Community\Resources\Houses\Schemas\HouseForm;
use App\Filament\Community\Resources\Houses\Tables\HousesTable;
use App\Models\House;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $modelLabel = 'Casa';

    protected static ?string $pluralModelLabel = 'Casas';

    protected static ?string $recordTitleAttribute = 'number';

    public static function form(Schema $schema): Schema
    {
        return HouseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HousesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FamiliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHouses::route('/'),
            'create' => CreateHouse::route('/create'),
            'edit' => EditHouse::route('/{record}/edit'),
        ];
    }
}
