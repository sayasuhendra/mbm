<?php

namespace App\Filament\Resources\WhatsappBroadcasts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WhatsappBroadcastForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)->schema([
                    \Filament\Schemas\Components\Grid::make(1)->schema([
                        \Filament\Schemas\Components\Section::make('Konten Pesan')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul / Subjek (Hanya untuk referensi internal)')
                                    ->required(),
                                Textarea::make('message')
                                    ->label('Isi Pesan WhatsApp')
                                    ->required()
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                    \Filament\Schemas\Components\Grid::make(1)->schema([
                        \Filament\Schemas\Components\Section::make('Pengaturan Pengiriman')
                            ->schema([
                                Select::make('target')
                                    ->label('Target Penerima')
                                    ->options([
                                        'all' => 'Seluruh peserta',
                                        'active' => 'Peserta aktif',
                                        'inactive' => 'Peserta tidak aktif',
                                    ])
                                    ->required()
                                    ->default('all'),
                                Select::make('status')
                                    ->label('Status Pengiriman')
                                    ->options([
                                        'draft' => 'Draft',
                                        'scheduled' => 'Terjadwal',
                                        'sent' => 'Terkirim',
                                    ])
                                    ->required()
                                    ->default('draft'),
                                DateTimePicker::make('scheduled_at')
                                    ->label('Jadwal Kirim (Kosongkan jika Draft/Sekarang)'),
                                DateTimePicker::make('sent_at')
                                    ->label('Waktu Terkirim')
                                    ->disabled(),
                            ]),
                        Hidden::make('created_by')
                            ->default(auth()->id()),
                    ])->columnSpan(['lg' => 1]),
                ]),
            ]);
    }
}
