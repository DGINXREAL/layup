<?php

declare(strict_types=1);

namespace Crumbls\Layup\Contracts;

/**
 * Contract for all Layup page builder widgets.
 *
 * Implement this interface to create custom widgets. Each widget defines
 * its own editing form (Filament Schema), default data, preview text
 * for the builder canvas, and optional callbacks for lifecycle events.
 */
interface Widget
{
    /**
     * Unique string identifier for this widget type.
     * Used in JSON storage and widget registry lookups.
     */
    public static function getType(): string;

    /**
     * Human-readable label shown in the widget picker and builder canvas.
     */
    public static function getLabel(): string;

    /**
     * Heroicon name for UI display in the widget picker.
     */
    public static function getIcon(): string;

    /**
     * Category for grouping in the widget picker.
     * Core categories: 'content', 'media', 'layout', 'interactive', 'advanced'
     */
    public static function getCategory(): string;

    /**
     * Filament form schema components for editing this widget's data.
     *
     * @return array<\Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array;

    /**
     * Default data values when a new widget instance is created.
     */
    public static function getDefaultData(): array;

    /**
     * Generate a short plain-text preview for the builder canvas.
     * Receives the widget's stored data array.
     */
    public static function getPreview(array $data): string;

    /**
     * Called after the widget data is saved via the slideover.
     * Use for validation, transformation, or side effects (e.g., image processing).
     *
     * Return the (possibly modified) data array.
     */
    public static function onSave(array $data): array;

    /**
     * Called when the widget is first created (added to a column).
     * Use for initialization logic beyond default data.
     *
     * Return the initial data array.
     */
    public static function onCreate(array $data): array;

    /**
     * Called when the widget is deleted from a column.
     * Use for cleanup (e.g., deleting uploaded files).
     */
    public static function onDelete(array $data): void;

    /**
     * Serialize widget metadata for the Alpine.js builder.
     */
    public static function toArray(): array;
}
