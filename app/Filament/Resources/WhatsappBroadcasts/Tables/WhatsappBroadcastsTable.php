<?php

namespace App\Filament\Resources\WhatsappBroadcasts\Tables;

use App\Filament\Exports\WhatsappBroadcastExporter;
use App\Jobs\SendWhatsappBroadcastJob;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WhatsappBroadcastsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('target')
                    ->label('Target')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'all' => 'Seluruh peserta',
                        'active' => 'Peserta aktif',
                        'inactive' => 'Peserta tidak aktif',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'scheduled' => 'Terjadwal',
                        'sent' => 'Terkirim',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('scheduled_at')
                    ->label('Jadwal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('sent_at')
                    ->label('Terkirim')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'scheduled' => 'Terjadwal',
                    'sent' => 'Terkirim',
                ]),
            ])
            ->recordActions([
                Action::make('sendNow')
                    ->label('Kirim')
                    ->requiresConfirmation()
                    ->visible(fn ($record): bool => $record->status !== 'sent')
                    ->action(function ($record): void {
                        SendWhatsappBroadcastJob::dispatch($record->id);
                        Notification::make()->title('Broadcast masuk antrean pengiriman.')->success()->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exporter(WhatsappBroadcastExporter::class)
                    ->formats([ExportFormat::Xlsx]),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
