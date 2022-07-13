<?php

namespace Modules\License\Filament\Resources\VerbResource\Pages;

use Modules\License\Filament\Resources\VerbResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVerb extends EditRecord
{
    protected static string $resource = VerbResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
