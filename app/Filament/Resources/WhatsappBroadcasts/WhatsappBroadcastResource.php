<?php

namespace App\Filament\Resources\WhatsappBroadcasts;

use App\Filament\Resources\WhatsappBroadcasts\Pages\CreateWhatsappBroadcast;
use App\Filament\Resources\WhatsappBroadcasts\Pages\EditWhatsappBroadcast;
use App\Filament\Resources\WhatsappBroadcasts\Pages\ListWhatsappBroadcasts;
use App\Filament\Resources\WhatsappBroadcasts\Schemas\WhatsappBroadcastForm;
use App\Filament\Resources\WhatsappBroadcasts\Tables\WhatsappBroadcastsTable;
use App\Models\WhatsappBroadcast;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WhatsappBroadcastResource extends Resource
{
    protected static ?string $model = WhatsappBroadcast::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?string $modelLabel = 'Broadcast WhatsApp';

    protected static ?string $pluralModelLabel = 'Broadcast WhatsApp';

    protected static UnitEnum|string|null $navigationGroup = 'Komunikasi';

    public static function form(Schema $schema): Schema
    {
        return WhatsappBroadcastForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhatsappBroadcastsTable::configure($table);
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
            'index' => ListWhatsappBroadcasts::route('/'),
            'create' => CreateWhatsappBroadcast::route('/create'),
            'edit' => EditWhatsappBroadcast::route('/{record}/edit'),
        ];
    }
}
