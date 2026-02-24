<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class AnchorWidget extends BaseWidget
{
    public static function getType(): string
    {
        return 'anchor';
    }

    public static function getLabel(): string
    {
        return 'Anchor / Jump Link';
    }

    public static function getIcon(): string
    {
        return 'heroicon-o-link';
    }

    public static function getCategory(): string
    {
        return 'layout';
    }

    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('anchor_id')
                ->label('Anchor ID')
                ->helperText('Use #this-id in URLs or links to jump here')
                ->required(),
            TextInput::make('offset')
                ->label('Scroll Offset (px)')
                ->helperText('Negative value scrolls above this point (useful for sticky headers)')
                ->numeric()
                ->default(0),
            Toggle::make('invisible')
                ->label('Invisible (no visual output)')
                ->default(true),
        ];
    }

    public static function getDefaultData(): array
    {
        return [
            'anchor_id' => '',
            'offset' => 0,
            'invisible' => true,
        ];
    }

    public static function getPreview(array $data): string
    {
        return '⚓ #' . ($data['anchor_id'] ?? '');
    }
}
