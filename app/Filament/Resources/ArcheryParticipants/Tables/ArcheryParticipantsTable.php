<?php

namespace App\Filament\Resources\ArcheryParticipants\Tables;

use App\Filament\Exports\ArcheryParticipantExporter;
use App\Models\ArcheryParticipant;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ArcheryParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member_number')
                    ->label('No. Anggota')
                    ->searchable(),
                TextColumn::make('parent_name')
                    ->label('Orang Tua')
                    ->searchable(),
                TextColumn::make('parent_whatsapp')
                    ->label('WhatsApp')
                    ->searchable(),
                TextColumn::make('child_name')
                    ->label('Anak')
                    ->searchable(),
                TextColumn::make('child_age')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('child_school_class')
                    ->searchable(),
                IconColumn::make('training_permission')
                    ->boolean(),
                TextColumn::make('weekly_donation_amount')
                    ->label('Infak')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('equipment_option')
                    ->label('Perlengkapan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'self_purchase_full' => 'Beli Sendiri Busur & Anak Panah',
                        'self_purchase_arrows' => 'Beli Sendiri Anak Panah',
                        'provided_by_committee' => 'Disediakan panitia',
                        'shared_contribution' => 'Siap urunan',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'exited' => 'Keluar',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('registered_at')
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
                    'pending' => 'Menunggu',
                    'active' => 'Aktif',
                    'inactive' => 'Tidak Aktif',
                    'exited' => 'Keluar',
                ]),
            ])
            ->recordActions([
                Action::make('setActive')
                    ->label('Set Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (ArcheryParticipant $record) => $record->update(['status' => ArcheryParticipant::STATUS_ACTIVE]))
                    ->visible(fn (ArcheryParticipant $record) => $record->status !== ArcheryParticipant::STATUS_ACTIVE),
                Action::make('setInactive')
                    ->label('Set Tidak Aktif')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(fn (ArcheryParticipant $record) => $record->update(['status' => ArcheryParticipant::STATUS_INACTIVE]))
                    ->visible(fn (ArcheryParticipant $record) => $record->status !== ArcheryParticipant::STATUS_INACTIVE),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Export ke Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->button()
                    ->exporter(ArcheryParticipantExporter::class)
                    ->formats([ExportFormat::Xlsx]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkSetActive')
                        ->label('Set Aktif')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each->update(['status' => ArcheryParticipant::STATUS_ACTIVE]))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('bulkSetInactive')
                        ->label('Set Tidak Aktif')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn (Collection $records) => $records->each->update(['status' => ArcheryParticipant::STATUS_INACTIVE]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
