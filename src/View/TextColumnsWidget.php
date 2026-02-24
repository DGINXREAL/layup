<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class TextColumnsWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'text-columns';
    }

    public static function getLabel(): string
    {
        return 'Text Columns';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-view-columns';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getContentFormSchema(): array
    {
        return [
            RichEditor::make('content')->label('Content')->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'h2', 'h3'])->columnSpanFull(),
            Select::make('columns')->label('Columns')->options(['2' => '2', '3' => '3', '4' => '4'])->default('2'),
            Select::make('gap')->label('Gap')->options(['1rem' => 'Small', '2rem' => 'Medium', '3rem' => 'Large'])->default('2rem'),
        ];
    }

    public static function getDefaultData(): array
    {
        return ['content' => '', 'columns' => '2', 'gap' => '2rem'];
    }

    public static function getPreview(array $data): string
    {
        return '📝 Text Columns (' . ($data['columns'] ?? 2) . ')';
    }
}
