<?php

namespace App\Filament\Resources\ArcheryParticipants\Tables;

use App\Models\ArcheryParticipant;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
                \Filament\Actions\Action::make('setActive')
                    ->label('Set Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (ArcheryParticipant $record) => $record->update(['status' => ArcheryParticipant::STATUS_ACTIVE]))
                    ->visible(fn (ArcheryParticipant $record) => $record->status !== ArcheryParticipant::STATUS_ACTIVE),
                \Filament\Actions\Action::make('setInactive')
                    ->label('Set Tidak Aktif')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(fn (ArcheryParticipant $record) => $record->update(['status' => ArcheryParticipant::STATUS_INACTIVE]))
                    ->visible(fn (ArcheryParticipant $record) => $record->status !== ArcheryParticipant::STATUS_INACTIVE),
                EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\Action::make('exportCsv')
                    ->label('Export CSV')
                    ->action(function (): StreamedResponse {
                        return response()->streamDownload(function () {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, ['No Anggota', 'Orang Tua', 'WhatsApp', 'Anak', 'Usia', 'Kelas/Sekolah', 'Status']);
                            ArcheryParticipant::query()->orderBy('member_number')->each(function ($participant) use ($handle) {
                                fputcsv($handle, [
                                    $participant->member_number,
                                    $participant->parent_name,
                                    $participant->parent_whatsapp,
                                    $participant->child_name,
                                    $participant->child_age,
                                    $participant->child_school_class,
                                    $participant->status,
                                ]);
                            });
                            fclose($handle);
                        }, 'peserta-panahan.csv');
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('bulkSetActive')
                        ->label('Set Aktif')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['status' => ArcheryParticipant::STATUS_ACTIVE]))
                        ->deselectRecordsAfterCompletion(),
                    \Filament\Actions\BulkAction::make('bulkSetInactive')
                        ->label('Set Tidak Aktif')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['status' => ArcheryParticipant::STATUS_INACTIVE]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
