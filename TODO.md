# Layup — Sprint TODO (overnight Feb 23-24)

## Priority 1: Testing ✅ COMPLETE
- [x] Frontend/HTTP Tests (22 tests)
- [x] SafelistCollector Tests (16 tests)
- [x] Artisan Command Tests (4 + 3 make-widget)
- [x] ContentValidator Tests (14 tests)
- [x] Rendering Tests (28 tests)
- [x] PageTemplate Tests (7 tests)
- [x] Revision Tests (4 tests)
- [x] Section Tests (7 tests)
- [x] PageModel Section Tests (2 tests)

## Priority 2: Missing Divi Features ✅ COMPLETE

### Sections (wraps rows) ✅
- [x] `Section` view component — outermost wrapper around rows
- [x] Section settings: background image/video/gradient, parallax, fullscreen height
- [x] Section blade renders rows inside with overlay support
- [x] Page model: `getSectionTree()` supports both legacy `{ rows }` and new `{ sections }`

### Design Tab Enhancements ✅
- [x] Text color picker, Font size selector, Text alignment
- [x] Border radius, Border (width/style/color), Box shadow presets
- [x] Opacity slider

### Responsive Visibility ✅
- [x] Show/hide per breakpoint toggle, generates hidden/block classes

### Animations/Transitions ✅
- [x] 6 entrance animations via Alpine x-intersect, configurable duration

## Priority 3: Builder UX Polish

### Widget Picker
- [ ] Widget icons in picker modal
- [ ] Recently used widgets
- [ ] Drag from picker to canvas

### Builder Canvas
- [ ] Live preview of widget content
- [ ] Inline text editing
- [ ] Visual column resize handles

### Page Management ✅ MOSTLY COMPLETE
- [x] Duplicate page, Bulk publish/unpublish, Export/Import JSON
- [x] Revision history (auto-save, prune, restore)
- [ ] Revision browser UI in EditPage

## Priority 4: Portability & DX ✅ COMPLETE
- [x] Export/Import JSON, Page templates (5 built-in), Save as template
- [x] SEO: OG tags, Twitter Cards, canonical, JSON-LD breadcrumbs
- [x] Sitemap helper (Page::sitemapEntries())
- [x] layup:install command, Widget auto-discovery, Extra safelist classes
- [x] layup:make-widget scaffolding command
- [x] layup:audit health check command
- [ ] Structured data: more schema.org types

## Priority 5: Widget Polish ✅ MOSTLY COMPLETE

### Completed
- [x] All original widget enhancements (heading, image, button, video, blurb, CTA, testimonial, pricing, map, social, gallery)
- [x] Hover states: Button hover colors, Image hover effects (zoom, grayscale, brighten, blur)

### New Widgets Added (17 new, 47 total)
- [x] Code Block, Alert, Table, Embed, Progress Circle (batch 1)
- [x] Menu, Search, Contact Form (batch 2)
- [x] Star Rating, Logo Grid, Blockquote, Feature List (batch 3)
- [x] Timeline, Stat Card, Marquee, Before/After (batch 4)
- [x] Team Grid, Notification Bar (batch 5)
- [x] Hero Section, Breadcrumbs (batch 6)
- [x] Testimonial Carousel, Comparison Table (batch 7)

### Remaining
- [ ] Gallery: caption per image
- [ ] Blurb: icon picker UI

## Summary (as of ~3am MST)
- **587 tests, 1171 assertions** — all passing
- **47 widgets** total
- **8 Alpine.js components** + inline Alpine in many widgets
- **5 page templates** (blank, landing, about, contact, pricing)
- **4 artisan commands** (install, safelist, make-widget, audit)
- **Section component** with background image/video/gradient/parallax/overlay
- **Revision history** with auto-save and pruning
- **Full Design tab**: text color, alignment, font size, border, border radius, box shadow, opacity
- **Responsive visibility**: hide on any breakpoint
- **Entrance animations**: 6 types with configurable duration
- **SEO**: OG, Twitter, canonical, JSON-LD breadcrumbs, sitemap helper
