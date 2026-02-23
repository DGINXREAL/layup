<?php

declare(strict_types=1);

namespace Crumbls\Layup\View;

use Crumbls\Layup\Contracts\Widget;
use Illuminate\Contracts\View\View;

abstract class BaseWidget extends BaseView implements Widget
{
    abstract public static function getType(): string;

    abstract public static function getLabel(): string;

    abstract public static function getFormSchema(): array;

    public static function getIcon(): string
    {
        return 'heroicon-o-puzzle-piece';
    }

    public static function getCategory(): string
    {
        return 'content';
    }

    public static function getDefaultData(): array
    {
        return [];
    }

    /**
     * Generate preview text for the builder canvas.
     * Override in subclasses for richer previews.
     */
    public static function getPreview(array $data): string
    {
        if (! empty($data['content'])) {
            $text = strip_tags($data['content']);

            return mb_strlen($text) > 60 ? mb_substr($text, 0, 60) . '…' : $text;
        }

        if (! empty($data['label'])) {
            return $data['label'];
        }

        if (! empty($data['src'])) {
            return '🖼 ' . basename($data['src']);
        }

        return '(empty)';
    }

    /**
     * Called after save. Override to transform or validate data.
     */
    public static function onSave(array $data): array
    {
        return $data;
    }

    /**
     * Called on widget creation. Override for init logic.
     */
    public static function onCreate(array $data): array
    {
        return $data;
    }

    /**
     * Called on widget deletion. Override for cleanup.
     */
    public static function onDelete(array $data): void
    {
        // No-op by default
    }

    public static function toArray(): array
    {
        return [
            'type' => static::getType(),
            'label' => static::getLabel(),
            'icon' => static::getIcon(),
            'category' => static::getCategory(),
            'defaults' => static::getDefaultData(),
        ];
    }

    /**
     * Get the view name for frontend rendering.
     * Convention: layup::widgets.{type}
     * Override for custom view paths.
     */
    protected function getViewName(): string
    {
        return 'layup::widgets.' . static::getType();
    }

    public function render(): View
    {
        return view($this->getViewName(), [
            'data' => $this->data,
            'children' => $this->children,
        ]);
    }
}
