# Layup — Sprint TODO (overnight Feb 23-24)

## Priority 1: Testing ✅ COMPLETE
- [x] Frontend/HTTP Tests (22 tests)
- [x] SafelistCollector Tests (16 tests)
- [x] Artisan Command Tests (4 tests)
- [x] ContentValidator Tests (14 tests)
- [x] Rendering Tests (28 tests)
- [x] PageTemplate Tests (7 tests)
- [x] Revision Tests (4 tests)

## Priority 2: Missing Divi Features ✅ COMPLETE

### Sections (wraps rows) ✅
- [x] `Section` view component — outermost wrapper around rows
- [x] Section settings: background image/video/gradient, parallax, fullscreen height
- [x] Update page content structure: supports both `{ sections: [...] }` and legacy `{ rows: [...] }`

### Design Tab Enhancements ✅
- [x] Text color picker, Font size selector, Text alignment
- [x] Border radius, Border (width/style/color), Box shadow presets
- [x] Opacity slider

### Responsive Visibility ✅
- [x] Show/hide per breakpoint toggle, generates hidden/block classes

### Animations/Transitions ✅
- [x] 6 entrance animations via Alpine x-intersect, configurable duration

## Priority 3: Builder UX Polish

### Widget Picker ✅ COMPLETE
- [x] Widget icons in picker modal
- [x] Recently used widgets
- [x] Drag from picker to canvas

### Builder Canvas
- [ ] Live preview of widget content
- [ ] Inline text editing
- [ ] Visual column resize handles

### Page Management ✅ COMPLETE
- [x] Duplicate page, Bulk publish/unpublish, Export/Import JSON
- [x] Revision history (auto-save, prune, restore)
- [x] Revision browser UI in EditPage

## Priority 4: Portability & DX ✅ COMPLETE
- [x] Export/Import JSON, Page templates (5 built-in), Save as template
- [x] SEO: OG tags, Twitter Cards, canonical, JSON-LD breadcrumbs
- [x] Sitemap helper (Page::sitemapEntries())
- [x] layup:install command, Widget auto-discovery, Extra safelist classes
- [x] Structured data: WebPage, Article/BlogPosting, FAQPage schema.org types
- [x] `layup:make-widget` artisan command (scaffold custom widgets)
- [x] `layup:audit` command (page health check, widget usage stats)

## Priority 5: Widget Polish ✅ MOSTLY COMPLETE
- [x] Heading: link URL
- [x] Image: link URL, new tab
- [x] Button: custom bg/text colors, hover colors via Alpine
- [x] Video: privacy-enhanced mode (youtube-nocookie.com)
- [x] Blurb: text alignment, right layout support
- [x] CTA: button style, bg/text colors, new tab
- [x] Testimonial: star rating, company name
- [x] PricingTable: custom badge text
- [x] Map: map type (roadmap/satellite/terrain/hybrid)
- [x] SocialFollow: icon size
- [x] Gallery: lightbox + captions
- [x] Image: hover effects (zoom, grayscale→color, brighten, blur→clear)
- [ ] Blurb: icon picker UI (nice-to-have)

## Summary (as of ~3:30am MST Feb 24)
- **852 tests, 1706 assertions** — all passing
- **75 widgets** total
- **Section component** with background image/video/gradient, parallax, overlay
- **Structured data** (WebPage, Article, FAQPage, BreadcrumbList)
- **Page templates** (5 built-in), revision history, content validator
- **3 artisan commands**: layup:install, layup:safelist, layup:make-widget, layup:audit
- **Alpine.js components** for interactive widgets (accordion, tabs, countdown, slider, lightbox, etc.)
- **Full Design/Advanced tabs** on all widgets (colors, borders, spacing, animations, visibility)

## Future (post-sprint)
- Widget icons in picker modal
- Live preview / inline editing on builder canvas
- Visual column resize handles
- Revision browser UI
- Drag from widget picker to canvas
- More page templates
- Publish to Packagist
