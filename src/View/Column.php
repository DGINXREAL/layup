<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Crumbls\Layup\Forms\Components\SpacingPicker;
use Crumbls\Layup\Forms\Components\SpanPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\View\View;

class Column extends BaseView
{
    protected array $span = [
        'sm' => 12,
        'md' => 12,
        'lg' => 12,
        'xl' => 12,
    ];

    public function __construct(array $data = [], array $children = [])
    {
        parent::__construct($data, $children);

        if (isset($data['span'])) {
            $this->span = array_merge($this->span, $data['span']);
        }
    }

    /**
     * Set the column span for one or all breakpoints.
     *
     * @param  int|array<string, int>  $span
     */
    public function span(int|array $span): static
    {
        if (is_int($span)) {
            $this->span = [
                'sm' => $span,
                'md' => $span,
                'lg' => $span,
                'xl' => $span,
            ];
        } else {
            $this->span = array_merge($this->span, $span);
        }

        return $this;
    }

    /**
     * Get the column span configuration.
     *
     * @return array<string, int>
     */
    public function getSpan(): array
    {
        return $this->span;
    }

    /**
     * Two tabs: Design and Advanced.
     */
    public static function getFormSchema(): array
    {
        return [
            Tabs::make('settings')
                ->tabs([
                    Tab::make('Design')
                        ->icon('heroicon-o-paint-brush')
                        ->schema(static::getDesignFormSchema()),
                    Tab::make('Advanced')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema(static::getAdvancedFormSchema()),
                ])
                ->columnSpanFull(),
        ];
    }

    /**
     * Design tab: span pickers, alignment, overflow, padding, margin, background.
     */
    public static function getDesignFormSchema(): array
    {
        $breakpoints = config('layup.breakpoints', []);

        $spanPickers = [];
        foreach ($breakpoints as $key => $bp) {
            $spanPickers[] = SpanPicker::make("span.{$key}")
                ->label('')
                ->breakpointLabel($bp['label'] ?? $key)
                ->color(match ($key) {
                    'sm' => '#ef4444',
                    'md' => '#f59e0b',
                    'lg' => '#22c55e',
                    'xl' => '#3b82f6',
                    default => '#8b5cf6',
                })
                ->default(12);
        }

        return [
            ...$spanPickers,
            Select::make('align_self')
                ->label('Align Self')
                ->options([
                    'auto' => 'Auto',
                    'start' => 'Start',
                    'center' => 'Center',
                    'end' => 'End',
                    'stretch' => 'Stretch',
                    'baseline' => 'Baseline',
                ])
                ->default('auto'),
            Select::make('overflow')
                ->label('Overflow')
                ->options([
                    'visible' => 'Visible',
                    'hidden' => 'Hidden',
                    'auto' => 'Auto',
                    'scroll' => 'Scroll',
                ])
                ->default('visible'),
            ...parent::getDesignFormSchema(),
        ];
    }

    public function render(): View
    {
        return view('layup::components.column', [
            'children' => $this->children,
            'span' => $this->span,
            'data' => $this->data,
        ]);
    }
}
