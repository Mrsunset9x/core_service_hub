<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Forms\Components\CustomComponent;
use App\Forms\Components\RangeSlider;
use App\Models\Exercise;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description')->required(),
//                ImageColumn::make('sub_description'),
                RangeSlider::make('test'),

//                Fieldset::make('Label')
//                    ->schema([
//                        Forms\Components\TextInput::make('name')->required(),
//                    ]),
//                Wizard::make([
//                    Wizard\Step::make('name')
//                        ->schema([
//                            Forms\Components\TextInput::make('name')->required(),
//                        ]),
//                    Wizard\Step::make('description')
//                        ->schema([
//                            Forms\Components\TextInput::make('description')->required(),
//                        ]),
//                    Wizard\Step::make('sub_description')
//                        ->schema([
//                            Forms\Components\TextInput::make('sub_description')->required(),
//                        ]),
//                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\ImageColumn::make('sub_description'),
            ])
            ->defaultSort('id','desc')
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
            'index' => Pages\ListExercises::route('/'),
            'create' => Pages\CreateExercise::route('/create'),
            'edit' => Pages\EditExercise::route('/{record}/edit'),
        ];
    }    
}
