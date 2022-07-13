<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductResource extends Resource implements HasForms
{

    use InteractsWithForms;
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form($layout = Forms\Components\Grid::class): Form
    {

        return $layout::make()
            ->schema([
                SpatieMediaLibraryFileUpload::make('thumbnail')->label('Thumbnail')
                    ->image()
                    ->enableDownload()
                    ->collection('product-images')
                    ->preserveFilenames()
                    ->columns(1)->nullable(),
                SpatieMediaLibraryFileUpload::make('avatar')->label('Avatar')
                    ->image()
                    ->enableDownload()
                    ->collection('product-avatar')
                    ->preserveFilenames()
                    ->columns(1)->nullable(),
                Forms\Components\TextInput::make('name')->label('name')->reactive()->afterStateUpdated(
                    function ($state,callable $set) {
                        $set('slug',Str::slug($state));
                    }
                )->required(),
                Forms\Components\TextInput::make('slug')->label('Slug')->nullable(),
                Forms\Components\TextInput::make('description')->label('Description')->nullable(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->collection('product-images'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('avatar')
                    ->label('Avatar')
                    ->collection('product-avatar'),
            ])->defaultSort('id','desc')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

}
