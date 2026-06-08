<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengeluaran')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            DatePicker::make('date')
                                ->label('Tanggal')
                                ->default(now())
                                ->required(),
                            Select::make('expense_category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
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
