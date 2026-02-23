<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Crumbls\Layup\Forms\Components\SpacingPicker;
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

    public function __construct(array $data = [], array $children = [])
    {
        $this->data = $data;
        $this->children = $children;
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
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;
}
