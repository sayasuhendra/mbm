<?php

namespace App\Filament\Resources\TrainingSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('day_of_week')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->time()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->time()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('setActive')
                    ->label('Set Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (\App\Models\TrainingSchedule $record) => $record->update(['is_active' => true]))
                    ->visible(fn (\App\Models\TrainingSchedule $record) => ! $record->is_active),
                \Filament\Actions\Action::make('setInactive')
                    ->label('Set Tidak Aktif')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->action(fn (\App\Models\TrainingSchedule $record) => $record->update(['is_active' => false]))
                    ->visible(fn (\App\Models\TrainingSchedule $record) => $record->is_active),
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('bulkSetActive')
                        ->label('Set Aktif')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),
                    \Filament\Actions\BulkAction::make('bulkSetInactive')
                        ->label('Set Tidak Aktif')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
