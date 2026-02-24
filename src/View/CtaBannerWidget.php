<?php
declare(strict_types=1);
namespace Crumbls\Layup\View;
use Filament\Forms\Components\TextInput;
class CtaBannerWidget extends BaseWidget
{
    public static function getType(): string { return 'cta-banner'; }
    public static function getLabel(): string { return 'CTA Banner'; }
    public static function getIcon(): string { return 'heroicon-o-megaphone'; }
    public static function getCategory(): string { return 'interactive'; }
    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('heading')->label('Heading')->required(),
            TextInput::make('subtitle')->label('Subtitle')->nullable(),
            TextInput::make('button_text')->label('Button Text')->default('Get Started'),
            TextInput::make('button_url')->label('Button URL')->url()->default('#'),
            TextInput::make('bg_color')->label('Background Color')->type('color')->default('#3b82f6'),
            TextInput::make('text_color_banner')->label('Text Color')->type('color')->default('#ffffff'),
        ];
    }
    public static function getDefaultData(): array { return ['heading' => '', 'subtitle' => '', 'button_text' => 'Get Started', 'button_url' => '#', 'bg_color' => '#3b82f6', 'text_color_banner' => '#ffffff']; }
    public static function getPreview(array $data): string { return '📢 ' . ($data['heading'] ?? 'CTA Banner'); }
}
