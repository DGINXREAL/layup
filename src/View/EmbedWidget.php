<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class EmbedWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'embed';
    }

    public static function getLabel(): string
    {
        return 'Embed';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-globe-alt';
    }

    public static function getCategory(): string
    {
        return 'advanced';
    }

    public static function getContentFormSchema(): array
    {
        return [
            Textarea::make('html')
                ->label('Embed Code')
                ->helperText('Paste embed HTML (iframe, script, etc.)')
                ->rows(6)
                ->columnSpanFull(),
            Select::make('aspect')
                ->label('Aspect Ratio')
                ->options([
                    '' => 'Auto',
                    '16/9' => '16:9',
                    '4/3' => '4:3',
                    '1/1' => '1:1',
                    '21/9' => '21:9',
                ])
                ->default('')
                ->nullable(),
            TextInput::make('max_width')
                ->label('Max Width')
                ->placeholder('e.g. 600px')
                ->nullable(),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'html' => '',
            'aspect' => '',
            'max_width' => '',
        ];
    }

    public static function getPreview(array $data): string
    {
        if (empty($data['html'])) {
            return '(no embed code)';
        }

        return '🔗 Embedded content';
    }
}
