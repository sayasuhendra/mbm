<?php

namespace App\Filament\Resources\WeeklyDonations;

use App\Filament\Resources\WeeklyDonations\Pages\CreateWeeklyDonation;
use App\Filament\Resources\WeeklyDonations\Pages\EditWeeklyDonation;
use App\Filament\Resources\WeeklyDonations\Pages\ListWeeklyDonations;
use App\Filament\Resources\WeeklyDonations\Schemas\WeeklyDonationForm;
use App\Filament\Resources\WeeklyDonations\Tables\WeeklyDonationsTable;
use App\Models\WeeklyDonation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WeeklyDonationResource extends Resource
{
    protected static ?string $model = WeeklyDonation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $modelLabel = 'Infak Mingguan';

    protected static ?string $pluralModelLabel = 'Infak Mingguan';

    protected static UnitEnum|string|null $navigationGroup = 'Keuangan';

    public static function form(Schema $schema): Schema
    {
        return WeeklyDonationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeeklyDonationsTable::configure($table);
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
            'index' => ListWeeklyDonations::route('/'),
            'create' => CreateWeeklyDonation::route('/create'),
            'edit' => EditWeeklyDonation::route('/{record}/edit'),
        ];
    }
}
