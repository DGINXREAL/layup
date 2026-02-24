<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class HighlightBoxWidget extends BaseWidget
{
    public static function getType(): string { return 'highlight-box'; }
    public static function getLabel(): string { return 'Highlight Box'; }
    public static function getIcon(): string { return 'heroicon-o-light-bulb'; }
    public static function getCategory(): string { return 'content'; }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('title')->label('Title')->nullable(),
            RichEditor::make('content')->label('Content')->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])->columnSpanFull(),
            Select::make('variant')->label('Variant')->options([
                'info' => '💡 Info (blue)', 'tip' => '💚 Tip (green)', 'warning' => '⚠️ Warning (yellow)',
                'important' => '❗ Important (red)', 'note' => '📝 Note (gray)',
            ])->default('info'),
            TextInput::make('icon')->label('Custom Icon/Emoji')->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['title' => '', 'content' => '', 'variant' => 'info', 'icon' => ''];
    }

    public static function getPreview(array $data): string
    {
        return '💡 ' . ($data['title'] ?? 'Highlight Box');
    }
}
