<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class HeadingWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'heading';
    }

    public static function getLabel(): string
    {
        return 'Heading';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-h1';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('content')
                ->label('Heading Text')
                ->required(),
            Select::make('level')
                ->label('Level')
                ->options([
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ])
                ->default('h2'),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'content' => '',
            'level' => 'h2',
        ];
    }

    public static function getPreview(array $data): string
    {
        $level = strtoupper($data['level'] ?? 'H2');
        $text = $data['content'] ?? '';

        return $text ? "[{$level}] {$text}" : '(empty heading)';
    }
}
