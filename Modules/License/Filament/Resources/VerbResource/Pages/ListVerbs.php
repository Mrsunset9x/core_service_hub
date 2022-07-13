<?php

namespace Modules\License\Filament\Resources\VerbResource\Pages;

use Modules\License\Filament\Resources\VerbResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVerbs extends ListRecords
{
    protected static string $resource = VerbResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
