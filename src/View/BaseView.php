<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

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
     * Get the view / contents that represent the component.
     */
    abstract public function render(): View;
}
