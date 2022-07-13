<?php

namespace Modules\License\Filament\Resources;

use Modules\License\Filament\Resources\VerbResource\Pages;
use Modules\License\Filament\Resources\VerbResource\RelationManagers;
use Modules\License\Models\SkillVerb;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VerbResource extends Resource
{
    protected static ?string $model = SkillVerb::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListVerbs::route('/'),
            'create' => Pages\CreateVerb::route('/create'),
            'edit' => Pages\EditVerb::route('/{record}/edit'),
        ];
    }    
}
