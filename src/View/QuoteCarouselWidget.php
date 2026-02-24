<?php
declare(strict_types=1);
namespace Crumbls\Layup\View;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
class QuoteCarouselWidget extends BaseWidget
{
    public static function getType(): string { return 'quote-carousel'; }
    public static function getLabel(): string { return 'Quote Carousel'; }
    public static function getIcon(): string { return 'heroicon-o-chat-bubble-left-right'; }
    public static function getCategory(): string { return 'content'; }
    public static function getContentFormSchema(): array
    {
        return [
            Repeater::make('quotes')->label('Quotes')->schema([
                TextInput::make('text')->label('Quote')->required(),
                TextInput::make('author')->label('Author')->nullable(),
            ])->defaultItems(3)->columnSpanFull(),
            TextInput::make('interval')->label('Auto-play Interval (seconds)')->numeric()->default(5),
        ];
    }
    public static function getDefaultData(): array { return ['quotes' => [], 'interval' => 5]; }
    public static function getPreview(array $data): string { return '💬 Quote Carousel (' . count($data['quotes'] ?? []) . ')'; }
}
