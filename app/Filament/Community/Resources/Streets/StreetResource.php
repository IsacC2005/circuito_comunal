<?php

namespace App\Filament\Community\Resources\Streets;

use App\Filament\Community\Resources\Streets\Pages\CreateStreet;
use App\Filament\Community\Resources\Streets\Pages\EditStreet;
use App\Filament\Community\Resources\Streets\Pages\ListStreets;
use App\Filament\Community\Resources\Streets\Schemas\StreetForm;
use App\Filament\Community\Resources\Streets\Tables\StreetsTable;
use App\Models\Street;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StreetResource extends Resource
{
    protected static ?string $model = Street::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $modelLabel = 'Calle';

    protected static ?string $pluralModelLabel = 'Calles';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StreetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StreetsTable::configure($table);
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
            'index' => ListStreets::route('/'),
            'create' => CreateStreet::route('/create'),
            'edit' => EditStreet::route('/{record}/edit'),
        ];
    }
}
