<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');

    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (empty(Arr::get($data, 'password'))) {
            Arr::forget($data, 'password');
        }

        $data['thumbnail'] = Arr::get($data,'thumbnail');
        $record->update($data);
        return $record;
    }
}
