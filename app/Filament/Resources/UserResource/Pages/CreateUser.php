<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {

        $user = static::getModel()::create($data);
        $user->assignRoleUser($data);
        return $user;
    }


    private function getRoleById($id)
    {
        return Role::findById($id);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');

    }
}
