<?php

namespace App\Filament\Resources\TrainingSchedules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TrainingScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)->schema([
                    \Filament\Schemas\Components\Grid::make(1)->schema([
                        \Filament\Schemas\Components\Section::make('Informasi Dasar')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul / Nama Latihan')
                                    ->required(),
                                TextInput::make('location')
                                    ->label('Lokasi')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Deskripsi Latihan')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                    \Filament\Schemas\Components\Grid::make(1)->schema([
                        \Filament\Schemas\Components\Section::make('Waktu Pelaksanaan')
                            ->schema([
                                Select::make('day_of_week')
                                    ->label('Hari')
                                    ->options([
                                        0 => 'Ahad',
                                        1 => 'Senin',
                                        2 => 'Selasa',
                                        3 => 'Rabu',
                                        4 => 'Kamis',
                                        5 => 'Jumat',
                                        6 => 'Sabtu',
                                    ])
                                    ->required(),
                                TimePicker::make('starts_at')
                                    ->label('Waktu Mulai')
                                    ->required(),
                                TimePicker::make('ends_at')
                                    ->label('Waktu Selesai')
                                    ->required(),
                            ]),

                        \Filament\Schemas\Components\Section::make('Status')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Jadwal Aktif')
                                    ->default(true)
                                    ->required(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
                ]),
            ]);
    }
}
