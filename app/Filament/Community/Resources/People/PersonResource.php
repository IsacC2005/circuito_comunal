<?php

namespace App\Filament\Community\Resources\People;

use App\Filament\Community\Resources\People\Pages\CreatePerson;
use App\Filament\Community\Resources\People\Pages\EditPerson;
use App\Filament\Community\Resources\People\Pages\ListPeople;
use App\Filament\Community\Resources\People\Schemas\PersonForm;
use App\Filament\Community\Resources\People\Tables\PeopleTable;
use App\Models\Person;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?string $modelLabel = 'Persona';

    protected static ?string $pluralModelLabel = 'Personas';

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Schema $schema): Schema
    {
        return PersonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeopleTable::configure($table);
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
            'index' => ListPeople::route('/'),
            'create' => CreatePerson::route('/create'),
            'edit' => EditPerson::route('/{record}/edit'),
        ];
    }
}
