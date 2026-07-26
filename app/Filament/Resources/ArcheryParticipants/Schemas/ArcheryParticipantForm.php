<?php

namespace App\Filament\Resources\ArcheryParticipants\Schemas;

use App\Models\ArcheryParticipant;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class ArcheryParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    Grid::make(1)->schema([
                        Section::make('Informasi Pribadi Peserta')
                            ->schema([
                                TextInput::make('member_number')
                                    ->label('Nomor Anggota')
                                    ->default(fn () => ArcheryParticipant::nextMemberNumber())
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('child_name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                Grid::make(2)->schema([
                                    TextInput::make('child_age')
                                        ->label('Usia (Tahun)')
                                        ->required()
                                        ->numeric(),
                                    TextInput::make('child_school_class')
                                        ->label('Kelas / Asal Sekolah')
                                        ->required(),
                                ]),
                            ]),

                        Section::make('Informasi Orang Tua')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('parent_name')
                                        ->label('Nama Orang Tua')
                                        ->required(),
                                    TextInput::make('parent_whatsapp')
                                        ->label('Nomor WhatsApp')
                                        ->required(),
                                ]),
                                Textarea::make('parent_address')
                                    ->label('Alamat Lengkap')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('rt')
                                    ->label('RT')
                                    ->maxLength(20),
                            ]),
                    ])->columnSpan(1),

                    Grid::make(1)->schema([
                        Section::make('Status & Administrasi')
                            ->schema([
                                TextInput::make('event_name')
                                    ->label('Nama Kegiatan'),
                                Select::make('competition_category')
                                    ->label('Kategori Lomba')
                                    ->options([
                                        'kelas_3_6_pria' => 'Kelas 3-6 Pria',
                                        'kelas_3_6_wanita' => 'Kelas 3-6 Wanita',
                                        'remaja' => 'Remaja',
                                        'dewasa_pria' => 'Dewasa Pria',
                                    ]),
                                Select::make('status')
                                    ->label('Status Peserta')
                                    ->options([
                                        'pending' => 'Menunggu',
                                        'active' => 'Aktif',
                                        'inactive' => 'Tidak Aktif',
                                        'exited' => 'Keluar',
                                    ])
                                    ->required()
                                    ->default('pending'),
                                DateTimePicker::make('registered_at')
                                    ->label('Tanggal Daftar')
                                    ->default(now()),
                                Toggle::make('training_permission')
                                    ->label('Izin Mengikuti Latihan')
                                    ->required(),
                                TextInput::make('weekly_donation_amount')
                                    ->label('Kesanggupan Infak Mingguan')
                                    ->prefix('Rp')
                                    ->required()
                                    ->numeric()
                                    ->default(5000),
                            ]),

                        Section::make('Peralatan')
                            ->schema([
                                Select::make('equipment_option')
                                    ->label('Opsi Peralatan')
                                    ->options([
                                        'self_purchase_full' => 'Beli Sendiri Busur & Anak Panah',
                                        'self_purchase_arrows' => 'Beli Sendiri Anak Panah',
                                        'provided_by_committee' => 'Disediakan panitia',
                                        'shared_contribution' => 'Siap urunan',
                                    ])
                                    ->required()
                                    ->live(),
                            ]),

                        Section::make('Tambahan')
                            ->schema([
                                Textarea::make('suggestion')
                                    ->label('Saran / Masukan')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
