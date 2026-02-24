<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class MarqueeWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'marquee';
    }

    public static function getLabel(): string
    {
        return 'Marquee';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrow-right';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('text')
                ->label('Text')
                ->required()
                ->columnSpanFull(),
            Select::make('speed')
                ->label('Speed')
                ->options([
                    '30' => 'Slow',
                    '20' => 'Normal',
                    '10' => 'Fast',
                    '5' => 'Very Fast',
                ])
                ->default('20'),
            Select::make('direction')
                ->label('Direction')
                ->options([
                    'left' => 'Left',
                    'right' => 'Right',
                ])
                ->default('left'),
            Toggle::make('pause_on_hover')
                ->label('Pause on hover')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'text' => '',
            'speed' => '20',
            'direction' => 'left',
            'pause_on_hover' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        $text = $data['text'] ?? '';
        $short = mb_strlen($text) > 40 ? mb_substr($text, 0, 40) . '…' : $text;
        return "📜 {$short}";
    }
}
