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
        if (!empty($data['background_color'])) {
            $styles[] = "background-color: {$data['background_color']};";
        }
        if (!empty($data['inline_css'])) {
            $styles[] = $data['inline_css'];
        }

        return implode(' ', $styles);
    }

    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;
}
