<?php

namespace App\Filament\Resources\CodePromotionResource\Pages;

use App\Filament\Resources\CodePromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCodePromotions extends ListRecords
{
    protected static string $resource = CodePromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
