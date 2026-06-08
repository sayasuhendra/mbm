<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PaymentSettingsPage extends Page implements \Filament\Forms\Contracts\HasForms
{
    use \Filament\Forms\Concerns\InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected string $view = 'filament.pages.payment-settings-page';
    protected static ?string $navigationLabel = 'Pengaturan Pembayaran';
    protected static ?string $title = 'Pengaturan Pembayaran & QRIS';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'bank_account_name' => \App\Models\Setting::value('bank_account_name'),
            'bank_account_number' => \App\Models\Setting::value('bank_account_number'),
            'bank_name' => \App\Models\Setting::value('bank_name'),
            'qris_image' => \App\Models\Setting::value('qris_image'),
        ]);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Rekening Bank')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank (Contoh: BSI, Mandiri, BCA)')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('bank_account_name')
                            ->label('Atas Nama Rekening')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('bank_account_number')
                            ->label('Nomor Rekening')
                            ->required(),
                    ])->columns(3),
                \Filament\Schemas\Components\Section::make('QRIS')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('qris_image')
                            ->label('Gambar QRIS')
                            ->image()
                            ->directory('qris')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        \App\Models\Setting::updateOrCreate(['key' => 'bank_name'], ['value' => $data['bank_name'], 'type' => 'string', 'group' => 'payment']);
        \App\Models\Setting::updateOrCreate(['key' => 'bank_account_name'], ['value' => $data['bank_account_name'], 'type' => 'string', 'group' => 'payment']);
        \App\Models\Setting::updateOrCreate(['key' => 'bank_account_number'], ['value' => $data['bank_account_number'], 'type' => 'string', 'group' => 'payment']);
        \App\Models\Setting::updateOrCreate(['key' => 'qris_image'], ['value' => $data['qris_image'], 'type' => 'image', 'group' => 'payment']);

        \Filament\Notifications\Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
