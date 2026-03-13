<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\Community;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->revealable()
                    ->rule(Password::default())
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->hint(fn(string $operation) => $operation === 'edit' ? 'Dejar en blanco para no cambiar' : null),
                Select::make('roles')
                    ->label('Rol')
                    ->relationship('roles', 'name', fn($query) => $query->whereIn('name', ['super_admin', 'admin']))
                    ->getOptionLabelFromRecordUsing(fn($record) => match ($record->name) {
                        'super_admin' => 'Super Admin',
                        'admin'       => 'Admin de Comunidad',
                        default       => $record->name,
                    })
                    ->live()
                    ->required(),
                Select::make('communities')
                    ->label('Comunidad')
                    ->relationship('communities', 'name')
                    ->searchable()
                    ->preload()
                    ->visible(fn($get) => \Spatie\Permission\Models\Role::find($get('roles'))?->name === 'admin'),
            ]);
    }
}
