<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->label('Foto Galeri')
                    ->collection('gallery')
                    ->multiple()
                    ->reorderable()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
