<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class BeforeAfterWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'before-after';
    }

    public static function getLabel(): string
    {
        return 'Before / After';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrows-right-left';
    }

    public static function getCategory(): string
    {
        return 'media';
    }

    public static function getContentFormSchema(): array
    {
        return [
            FileUpload::make('before_image')
                ->label('Before Image')
                ->image()
                ->directory('layup/before-after')
                ->required(),
            FileUpload::make('after_image')
                ->label('After Image')
                ->image()
                ->directory('layup/before-after')
                ->required(),
            TextInput::make('before_label')
                ->label('Before Label')
                ->default('Before'),
            TextInput::make('after_label')
                ->label('After Label')
                ->default('After'),
            Select::make('initial_position')
                ->label('Initial Slider Position')
                ->options([
                    '25' => '25%',
                    '50' => '50%',
                    '75' => '75%',
                ])
                ->default('50'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'before_image' => '',
            'after_image' => '',
            'before_label' => 'Before',
            'after_label' => 'After',
            'initial_position' => '50',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '↔️ Before / After comparison';
    }
}
