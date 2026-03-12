<?php

namespace App\Filament\Admin\Resources\Communities\Tables;

use App\Models\Community;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class CommunitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('circuit.name')
                    ->label('Circuito')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code_citur')
                    ->label('Código CITUR')
                    ->searchable(),
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
                Action::make('invite_link')
                    ->label('Enlace de registro')
                    ->icon('heroicon-o-link')
                    ->color('success')
                    ->visible(fn (Community $record): bool => $record->users()->doesntExist())
                    ->fillForm(function (Community $record): array {
                        if (! $record->invitation_token) {
                            $record->update(['invitation_token' => Str::random(64)]);
                            $record->refresh();
                        }
                        return [
                            'invitation_url' => route('invite.show', $record->invitation_token),
                        ];
                    })
                    ->form([
                        TextInput::make('invitation_url')
                            ->label('Enlace de invitación')
                            ->helperText('Copia este enlace y envíaselo al responsable de la comunidad.')
                            ->readOnly()
                            ->copyable(),
                    ])
                    ->action(fn () => null)
                    ->modalSubmitActionLabel('Cerrar')
                    ->modalCancelAction(false)
                    ->modalHeading('Enlace de registro de usuario'),
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
