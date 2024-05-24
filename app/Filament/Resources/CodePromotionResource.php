<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CodePromotionResource\Pages;
use App\Filament\Resources\CodePromotionResource\RelationManagers;
use App\Models\CodePromotion;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CodePromotionResource extends Resource
{
    protected static ?string $modelLabel = 'Código de Promoção';
    protected static ?string $model = CodePromotion::class;
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Código de Promoção')
                    ->description('Visualize e gerencie os códigos de promoção por aqui.')
                    ->schema([
                        TextInput::make('code')
                            ->label('Código')
                            ->required()
                            ->minLength(3),

                        TextInput::make('discount')
                            ->required()
                            ->integer()
                            ->suffix('%')
                            ->label('Desconto')
                            ->minValue(1)
                            ->maxValue(100),
                        TextInput::make('limit_usage_per_user')
                            ->required()
                            ->integer()
                            ->label('Limite de uso por usuário')
                            ->placeholder('0 = ilimitado')
                            ->minValue(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Desconto em %')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('limit_usage_per_user')
                    ->label('Limite de uso por usuário')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCodePromotions::route('/'),
            'create' => Pages\CreateCodePromotion::route('/create'),
            'edit' => Pages\EditCodePromotion::route('/{record}/edit'),
        ];
    }
}
