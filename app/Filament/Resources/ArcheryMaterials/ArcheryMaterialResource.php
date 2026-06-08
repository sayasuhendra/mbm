<?php

namespace App\Filament\Resources\ArcheryMaterials;

use App\Filament\Resources\ArcheryMaterials\Pages\CreateArcheryMaterial;
use App\Filament\Resources\ArcheryMaterials\Pages\EditArcheryMaterial;
use App\Filament\Resources\ArcheryMaterials\Pages\ListArcheryMaterials;
use App\Filament\Resources\ArcheryMaterials\Schemas\ArcheryMaterialForm;
use App\Filament\Resources\ArcheryMaterials\Tables\ArcheryMaterialsTable;
use App\Models\ArcheryMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArcheryMaterialResource extends Resource
{
    protected static ?string $model = ArcheryMaterial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Section::make('Materi Panahan')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('title')
                        ->label('Judul Materi')
                        ->required()
                        ->maxLength(255),
                    \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                        ->collection('material_covers')
                        ->label('Gambar Cover')
                        ->image()
                        ->maxSize(2048)
                        ->columnSpanFull(),
                    \Filament\Forms\Components\MarkdownEditor::make('content')
                        ->label('Isi Materi')
                        ->required()
                        ->columnSpanFull(),
                    \Filament\Forms\Components\Toggle::make('is_active')
                        ->label('Aktif (Tampil)')
                        ->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ArcheryMaterialsTable::configure($table);
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
            'index' => ListArcheryMaterials::route('/'),
            'create' => CreateArcheryMaterial::route('/create'),
            'edit' => EditArcheryMaterial::route('/{record}/edit'),
        ];
    }
}
