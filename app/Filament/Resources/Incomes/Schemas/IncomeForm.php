<?php

namespace App\Filament\Resources\Incomes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IncomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pemasukan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            DatePicker::make('date')
                                ->label('Tanggal')
                                ->default(now())
                                ->required(),
                            Select::make('income_category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('source')
                                ->label('Sumber')
                                ->required(),
                            TextInput::make('amount')
                                ->label('Nominal')
                                ->prefix('Rp')
                                ->required()
                                ->numeric(),
                        ]),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                        Hidden::make('created_by')
                            ->default(auth()->id()),
                    ])
            ]);
    }
}
