<?php

namespace App\Filament\Resources\CodePromotionResource\Pages;

use App\Filament\Resources\CodePromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCodePromotion extends EditRecord
{
    protected static string $resource = CodePromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
