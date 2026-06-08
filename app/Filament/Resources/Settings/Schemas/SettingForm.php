<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Pengaturan')
                    ->schema([
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            TextInput::make('key')
                                ->label('Kunci')
                                ->required(),
                            Select::make('type')
                                ->label('Tipe')
                                ->options([
                                    'string' => 'String',
                                    'integer' => 'Integer',
                                    'boolean' => 'Boolean',
                                    'url' => 'URL',
                                ])
                                ->required()
                                ->default('string'),
                            TextInput::make('group')
                                ->label('Grup')
                                ->required()
                                ->default('general'),
                        ]),
                        Textarea::make('value')
                            ->label('Nilai')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
