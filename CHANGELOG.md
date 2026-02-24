# Changelog

All notable changes to Layup will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- 75 built-in widgets across Content, Media, Interactive, Layout, and Advanced categories
- Flex-based 12-column grid with responsive breakpoints (sm/md/lg/xl)
- Visual span picker for click-to-set column widths per breakpoint
- Drag & drop reordering for widgets and rows
- Undo/Redo with full history stack (Ctrl+Z / Ctrl+Shift+Z)
- Searchable, categorized widget picker modal
- Three-tab form schema (Content / Design / Advanced) on every component
- Full Design tab: text color, alignment, font size, border, radius, shadow, opacity, background, padding, margin
- Responsive visibility: show/hide per breakpoint on any element
- Entrance animations: fade in, slide up/down/left/right, zoom in (via Alpine x-intersect)
- Frontend rendering with configurable routes, layouts, and SEO meta
- Tailwind safelist generation with auto-sync on page save
- Page templates: 5 built-in + save your own
- Content revisions with auto-save and configurable max
- Export/Import pages as JSON
- Widget lifecycle hooks: `onSave`, `onCreate`, `onDelete`
- Content validation (structural + widget type)
- Widget auto-discovery from `App\Layup\Widgets`
- Configurable Page model per dashboard
- Blurb icon picker with 90+ searchable Heroicons
- `make:layup-widget` Artisan command
- Pint + Rector for code quality
- Pre-push hook running Pint and Pest

### Changed
- Editor CSS restyled to match Filament's native look (flat rows, dashed columns, elevated widget cards)
- Dark mode support via Filament CSS custom properties

## [0.1.0] - 2026-02-24

### Added
- Initial development release
