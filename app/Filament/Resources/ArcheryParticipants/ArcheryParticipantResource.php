<?php

namespace App\Filament\Resources\ArcheryParticipants;

use App\Filament\Resources\ArcheryParticipants\Pages\CreateArcheryParticipant;
use App\Filament\Resources\ArcheryParticipants\Pages\EditArcheryParticipant;
use App\Filament\Resources\ArcheryParticipants\Pages\ListArcheryParticipants;
use App\Filament\Resources\ArcheryParticipants\Schemas\ArcheryParticipantForm;
use App\Filament\Resources\ArcheryParticipants\Tables\ArcheryParticipantsTable;
use App\Models\ArcheryParticipant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ArcheryParticipantResource extends Resource
{
    protected static ?string $model = ArcheryParticipant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $modelLabel = 'Peserta Panahan';

    protected static ?string $pluralModelLabel = 'Peserta Panahan';

    protected static ?string $navigationLabel = 'Peserta Panahan';

    protected static UnitEnum|string|null $navigationGroup = 'Klub Panahan';

    public static function form(Schema $schema): Schema
    {
        return ArcheryParticipantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArcheryParticipantsTable::configure($table);
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
            'index' => ListArcheryParticipants::route('/'),
            'create' => CreateArcheryParticipant::route('/create'),
            'edit' => EditArcheryParticipant::route('/{record}/edit'),
        ];
    }
}
