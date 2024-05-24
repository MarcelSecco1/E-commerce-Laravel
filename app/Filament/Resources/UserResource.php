<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use DateTime;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $modelLabel = 'Usuários';
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Usuários')
                    ->description('Tenha total controle sobre os usuários do sistema.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->minLength(3),
                        TextInput::make('email')
                            ->required()
                            ->label('E-mail')
                            ->email(),
                        TextInput::make('password')
                            ->required()
                            ->label('Senha')
                            ->minLength(8)
                            ->password(),
                        ToggleButtons::make('is_admin')

                            ->label('É administrador?')
                            ->default(false)
                            ->boolean()
                            ->inline()
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')

                    ->searchable()
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->iconColor(Color::Blue)
                    ->copyable()
                    ->copyMessage('Email copiado!')
                    ->label('E-mail'),
                ToggleColumn::make('is_admin')
                    ->label('Administrador'),

                TextColumn::make('created_at')
                    ->label('Data de Criação')
                    ->dateTime()


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
