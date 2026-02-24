<?php
declare(strict_types=1);
namespace Crumbls\Layup\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
class SectionHeadingWidget extends BaseWidget
{
    public static function getType(): string { return 'section-heading'; }
    public static function getLabel(): string { return 'Section Heading'; }
    public static function getIcon(): string { return 'heroicon-o-bars-3'; }
    public static function getCategory(): string { return 'content'; }
    public static function getContentFormSchema(): array
    {
        return [
            TextInput::make('heading')->label('Heading')->required(),
            TextInput::make('subtitle')->label('Subtitle')->nullable(),
            Select::make('alignment')->label('Alignment')->options(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])->default('center'),
            Toggle::make('show_divider')->label('Show Divider')->default(true),
            TextInput::make('divider_color')->label('Divider Color')->type('color')->default('#3b82f6'),
            Select::make('heading_tag')->label('Heading Tag')->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3'])->default('h2'),
        ];
    }
    public static function getDefaultData(): array { return ['heading' => '', 'subtitle' => '', 'alignment' => 'center', 'show_divider' => true, 'divider_color' => '#3b82f6', 'heading_tag' => 'h2']; }
    public static function getPreview(array $data): string { return '📌 ' . ($data['heading'] ?? 'Section Heading'); }
}
