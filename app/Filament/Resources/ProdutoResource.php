<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoResource\Pages;
use App\Models\Produto;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Produtos')
                    ->description('Visualize e gerencie os produtos por aqui.')
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->minLength(3)
                            ->label('Nome')
                            ->required(),
                        TextInput::make('preco')
                            ->label('Preço')
                            ->minValue(0)
                            ->required()
                            ->numeric()
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(','),
                        FileUpload::make('imagem')
                            ->label('Imagem')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('descricao')
                            ->minLength(3)
                            ->maxLength(255)
                            ->label('Descrição')
                            ->required()
                            ->columnSpanFull(),

                        ToggleButtons::make('ativo')
                            ->label('O Produto está em estoque?')
                            ->boolean()
                            ->default(true)
                            ->inline()
                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagem')
                    ->circular()
                    ->label('Imagem'),
                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable(),
                TextColumn::make('preco')
                    ->label('Preço')
                    ->sortable()
                    ->money('BRL'),
                ToggleColumn::make('ativo')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
        ];
    }
}
