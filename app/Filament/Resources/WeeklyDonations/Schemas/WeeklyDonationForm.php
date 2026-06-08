<?php

namespace App\Filament\Resources\WeeklyDonations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WeeklyDonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Donasi / Infak')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            Select::make('archery_participant_id')
                                ->label('Peserta')
                                ->relationship('participant', 'child_name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            DatePicker::make('week_start_date')
                                ->label('Awal Pekan')
                                ->default(now()->startOfWeek())
                                ->required(),
                            TextInput::make('amount')
                                ->label('Nominal')
                                ->prefix('Rp')
                                ->required()
                                ->numeric(),
                        ]),
                    ]),
                \Filament\Schemas\Components\Section::make('Status Pembayaran')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'unpaid' => 'Belum Dibayar',
                                    'paid' => 'Sudah Dibayar',
                                ])
                                ->required()
                                ->default('unpaid'),
                            DateTimePicker::make('paid_at')
                                ->label('Dibayar Pada'),
                        ]),
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
