<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Crumbls\Layup\Forms\Components\SpacingPicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class BaseView extends Component
{
    /** @var array<BaseView> */
    protected array $children = [];

    protected array $data = [];

    protected bool $isFirst = false;

    protected bool $isLast = false;

    public function __construct(array $data = [], array $children = [])
    {
        $this->data = $data;
        $this->children = $children;
    }

    /**
     * Set position within parent (first/last) for gutter logic.
     */
    public function setPosition(bool $first = false, bool $last = false): static
    {
        $this->isFirst = $first;
        $this->isLast = $last;

        return $this;
    }

    public function isFirst(): bool
    {
        return $this->isFirst;
    }

    public function isLast(): bool
    {
        return $this->isLast;
    }

    /**
     * Get child components for recursive rendering.
     *
     * @return array<BaseView>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Set child components.
     *
     * @param  array<BaseView>  $children
     */
    public function setChildren(array $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Add a child component.
     */
    public function addChild(BaseView $child): static
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Check if this component has children.
     */
    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    /**
     * Get the data array.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Fluent constructor.
     */
    public static function make(array $data = [], array $children = []): static
    {
        return new static($data, $children);
    }

    /**
     * Full form schema with tabs.
     */
    public static function getFormSchema(): array
    {
        return [
            Tabs::make('settings')
                ->tabs([
                    Tab::make('Content')
                        ->icon('heroicon-o-document-text')
                        ->schema(static::getContentFormSchema()),
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
     * Content fields: override in subclasses for component-specific fields.
     *
     * @return array<\Filament\Schemas\Components\Component>
     */
    public static function getContentFormSchema(): array
    {
        return [];
    }

    /**
     * Design tab: padding, margin, background, etc.
     *
     * @return array<\Filament\Schemas\Components\Component>
     */
    public static function getDesignFormSchema(): array
    {
        return [
            TextInput::make('text_color')
                ->label('Text Color')
                ->type('color')
                ->nullable(),
            Select::make('text_align')
                ->label('Text Alignment')
                ->options([
                    '' => 'Default',
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                    'justify' => 'Justify',
                ])
                ->default('')
                ->nullable(),
            Select::make('font_size')
                ->label('Font Size')
                ->options([
                    '' => 'Default',
                    '0.75rem' => 'XS (12px)',
                    '0.875rem' => 'SM (14px)',
                    '1rem' => 'Base (16px)',
                    '1.125rem' => 'LG (18px)',
                    '1.25rem' => 'XL (20px)',
                    '1.5rem' => '2XL (24px)',
                    '1.875rem' => '3XL (30px)',
                    '2.25rem' => '4XL (36px)',
                    '3rem' => '5XL (48px)',
                ])
                ->default('')
                ->nullable(),
            Select::make('border_radius')
                ->label('Border Radius')
                ->options([
                    '' => 'None',
                    '0.25rem' => 'Small',
                    '0.375rem' => 'Medium',
                    '0.5rem' => 'Large',
                    '0.75rem' => 'XL',
                    '1rem' => '2XL',
                    '1.5rem' => '3XL',
                    '9999px' => 'Full',
                ])
                ->default('')
                ->nullable(),
            TextInput::make('border_width')
                ->label('Border Width')
                ->placeholder('e.g. 1px')
                ->nullable(),
            Select::make('border_style')
                ->label('Border Style')
                ->options([
                    '' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                ])
                ->default('')
                ->nullable(),
            TextInput::make('border_color')
                ->label('Border Color')
                ->type('color')
                ->nullable(),
            Select::make('box_shadow')
                ->label('Box Shadow')
                ->options([
                    '' => 'None',
                    '0 1px 2px 0 rgb(0 0 0 / 0.05)' => 'XS',
                    '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)' => 'Small',
                    '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)' => 'Medium',
                    '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)' => 'Large',
                    '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)' => 'XL',
                    '0 25px 50px -12px rgb(0 0 0 / 0.25)' => '2XL',
                ])
                ->default('')
                ->nullable(),
            SpacingPicker::advanced('padding', 'Padding'),
            SpacingPicker::advanced('margin', 'Margin'),
            TextInput::make('background_color')
                ->label('Background Color')
                ->type('color')
                ->nullable(),
        ];
    }

    /**
     * Advanced tab: ID, CSS classes, inline styles.
     *
     * @return array<\Filament\Schemas\Components\Component>
     */
    public static function getAdvancedFormSchema(): array
    {
        return [
            TextInput::make('id')
                ->label('ID')
                ->helperText('Optional unique identifier for this element')
                ->nullable()
                ->unique(ignoreRecord: true),
            TextInput::make('class')
                ->label('CSS Classes')
                ->helperText('Space-separated CSS classes')
                ->nullable(),
            Textarea::make('inline_css')
                ->label('Inline CSS')
                ->rows(4)
                ->placeholder('e.g. border: 1px solid red;')
                ->nullable(),
            CheckboxList::make('hide_on')
                ->label('Hide On')
                ->helperText('Hide this element on selected breakpoints')
                ->options([
                    'sm' => 'Mobile',
                    'md' => 'Tablet',
                    'lg' => 'Desktop',
                    'xl' => 'Large Desktop',
                ])
                ->columns(4)
                ->nullable(),
            Select::make('animation')
                ->label('Entrance Animation')
                ->options([
                    '' => 'None',
                    'fade-in' => 'Fade In',
                    'slide-up' => 'Slide Up',
                    'slide-down' => 'Slide Down',
                    'slide-left' => 'Slide Left',
                    'slide-right' => 'Slide Right',
                    'zoom-in' => 'Zoom In',
                ])
                ->default('')
                ->nullable(),
            Select::make('animation_duration')
                ->label('Animation Duration')
                ->options([
                    '300' => 'Fast (300ms)',
                    '500' => 'Normal (500ms)',
                    '700' => 'Slow (700ms)',
                    '1000' => 'Very Slow (1s)',
                ])
                ->default('500')
                ->visible(fn ($get) => !empty($get('animation')))
                ->nullable(),
        ];
    }

    /**
     * Build visibility classes from hide_on array.
     * Returns Tailwind classes like "hidden md:block" or "md:hidden lg:block".
     */
    public static function visibilityClasses(array $hideOn): string
    {
        if (empty($hideOn)) {
            return '';
        }

        $breakpoints = ['sm', 'md', 'lg', 'xl'];
        $classes = [];

        // If hiding on mobile (sm), start with hidden, then show at first non-hidden breakpoint
        // For each breakpoint, determine if it should be hidden or shown
        foreach ($breakpoints as $i => $bp) {
            $hidden = in_array($bp, $hideOn);
            $prevHidden = $i === 0 ? false : in_array($breakpoints[$i - 1], $hideOn);

            if ($i === 0 && $hidden) {
                $classes[] = 'hidden';
            } elseif ($i === 0 && !$hidden) {
                // default visible, no class needed
            } elseif ($hidden && !$prevHidden) {
                $classes[] = "{$bp}:hidden";
            } elseif (!$hidden && $prevHidden) {
                $classes[] = "{$bp}:block";
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Build inline style string from common data fields (text_color, text_align, background_color, inline_css).
     */
    public static function buildInlineStyles(array $data): string
    {
        $styles = [];

        if (!empty($data['text_color'])) {
            $styles[] = "color: {$data['text_color']};";
        }
        if (!empty($data['text_align'])) {
            $styles[] = "text-align: {$data['text_align']};";
        }
        if (!empty($data['font_size'])) {
            $styles[] = "font-size: {$data['font_size']};";
        }
        if (!empty($data['border_radius'])) {
            $styles[] = "border-radius: {$data['border_radius']};";
        }
        if (!empty($data['border_width']) && !empty($data['border_style'])) {
            $color = $data['border_color'] ?? '#e5e7eb';
            $styles[] = "border: {$data['border_width']} {$data['border_style']} {$color};";
        }
        if (!empty($data['box_shadow'])) {
            $styles[] = "box-shadow: {$data['box_shadow']};";
        }
        if (!empty($data['background_color'])) {
            $styles[] = "background-color: {$data['background_color']};";
        }
        if (!empty($data['inline_css'])) {
            $styles[] = $data['inline_css'];
        }

        return implode(' ', $styles);
    }

    /**
     * Build Alpine.js animation attributes for entrance animations.
     * Returns a string of Alpine directives to add to the element.
     */
    public static function animationAttributes(array $data): string
    {
        $animation = $data['animation'] ?? '';
        if (empty($animation)) {
            return '';
        }

        $duration = $data['animation_duration'] ?? '500';

        $initial = match ($animation) {
            'fade-in' => 'opacity: 0',
            'slide-up' => 'opacity: 0; transform: translateY(2rem)',
            'slide-down' => 'opacity: 0; transform: translateY(-2rem)',
            'slide-left' => 'opacity: 0; transform: translateX(2rem)',
            'slide-right' => 'opacity: 0; transform: translateX(-2rem)',
            'zoom-in' => 'opacity: 0; transform: scale(0.9)',
            default => '',
        };

        $final = match ($animation) {
            'fade-in' => 'opacity: 1',
            'slide-up', 'slide-down' => 'opacity: 1; transform: translateY(0)',
            'slide-left', 'slide-right' => 'opacity: 1; transform: translateX(0)',
            'zoom-in' => 'opacity: 1; transform: scale(1)',
            default => '',
        };

        if (empty($initial)) {
            return '';
        }

        return sprintf(
            'x-data="{ shown: false }" x-intersect.once="shown = true" '
            . ':style="shown ? \'%s; transition: all %sms ease-out\' : \'%s; transition: all %sms ease-out\'"',
            $final,
            $duration,
            $initial,
            $duration,
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;
}
