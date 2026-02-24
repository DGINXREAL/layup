<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class SkillBarWidget extends BaseWidget
{
    public static function getType(): string { return 'skill-bar'; }
    public static function getLabel(): string { return 'Skill Bar'; }
    public static function getIcon(): string { return 'heroicon-o-adjustments-horizontal'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('skills')
                ->label('Skills')
                ->schema([
                    TextInput::make('name')->label('Skill Name')->required(),
                    TextInput::make('percent')->label('Percentage')->numeric()->minValue(0)->maxValue(100)->required(),
                    TextInput::make('color')->label('Bar Color')->type('color')->default('#3b82f6'),
                ])
                ->defaultItems(3)
                ->columnSpanFull(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['skills' => [
            ['name' => 'PHP', 'percent' => 90, 'color' => '#3b82f6'],
            ['name' => 'JavaScript', 'percent' => 75, 'color' => '#f59e0b'],
            ['name' => 'Laravel', 'percent' => 95, 'color' => '#ef4444'],
        ]];
    }

    public static function getPreview(array $data): string
    {
        $count = count($data['skills'] ?? []);
        return "📊 Skill Bars ({$count})";
    }
}
