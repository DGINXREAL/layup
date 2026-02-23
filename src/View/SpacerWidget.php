<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;

class SpacerWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'spacer';
    }

    public static function getLabel(): string
    {
        return 'Spacer';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-arrows-up-down';
    }

    public static function getCategory(): string
    {
        return 'layout';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Select::make('height')
                ->label('Height')
                ->options([
                    '1rem' => 'Extra Small (1rem)',
                    '2rem' => 'Small (2rem)',
                    '3rem' => 'Medium (3rem)',
                    '4rem' => 'Large (4rem)',
                    '6rem' => 'Extra Large (6rem)',
                    '8rem' => 'Huge (8rem)',
                ])
                ->default('2rem'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'height' => '2rem',
        ];
    }

    public static function getPreview(array $data): string
    {
        return '↕ Spacer · ' . ($data['height'] ?? '2rem');
    }
}
