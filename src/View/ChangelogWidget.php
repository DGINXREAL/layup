<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ChangelogWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'changelog';
    }

    public static function getLabel(): string
    {
        return 'Changelog';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('releases')
                ->label('Releases')
                ->schema([
                    TextInput::make('version')->label('Version')->required(),
                    TextInput::make('date')->label('Date')->required(),
                    Select::make('type')->label('Type')->options([
                        'major' => 'Major', 'minor' => 'Minor', 'patch' => 'Patch',
                    ])->default('minor'),
                    Textarea::make('changes')->label('Changes (one per line)')->rows(4)->required(),
                ])
                ->defaultItems(2)
                ->columnSpanFull(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['releases' => []];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['releases'] ?? []);

        return "📋 Changelog ({$count} releases)";
    }
}
