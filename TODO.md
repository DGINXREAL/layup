# Layup — Sprint TODO (overnight Feb 23-24)

## Priority 1: Testing ✅ COMPLETE
- [x] Frontend/HTTP Tests (22 tests)
- [x] SafelistCollector Tests (16 tests)
- [x] Artisan Command Tests (4 tests)
- [x] ContentValidator Tests (14 tests)
- [x] Rendering Tests (28 tests)
- [x] PageTemplate Tests (7 tests)
- [x] Revision Tests (4 tests)

## Priority 2: Missing Divi Features

### Sections (wraps rows)
- [ ] `Section` view component — outermost wrapper around rows
- [ ] Section settings: background image/video/gradient, parallax, fullscreen height
- [ ] Update page content structure: `{ sections: [{ rows: [...] }] }`

### Design Tab Enhancements ✅ COMPLETE
- [x] Text color picker, Font size selector, Text alignment
- [x] Border radius, Border (width/style/color), Box shadow presets
- [x] Opacity slider

### Responsive Visibility ✅ COMPLETE
- [x] Show/hide per breakpoint toggle, generates hidden/block classes

### Animations/Transitions ✅ COMPLETE
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

## Priority 4: Portability & DX ✅ MOSTLY COMPLETE
- [x] Export/Import JSON, Page templates (5 built-in), Save as template
- [x] SEO: OG tags, Twitter Cards, canonical, JSON-LD breadcrumbs
- [x] Sitemap helper (Page::sitemapEntries())
- [x] layup:install command, Widget auto-discovery, Extra safelist classes
- [ ] Structured data: more schema.org types

## Priority 5: Widget Polish

### Completed
- [x] Heading: link URL
- [x] Image: link URL, new tab
- [x] Button: custom bg/text colors
- [x] Video: privacy-enhanced mode (youtube-nocookie.com)
- [x] Blurb: text alignment, right layout support
- [x] CTA: button style, bg/text colors, new tab
- [x] Testimonial: star rating, company name
- [x] PricingTable: custom badge text
- [x] Map: map type (roadmap/satellite/terrain/hybrid)
- [x] SocialFollow: icon size
- [x] Gallery: lightbox JS implementation

### New Widgets Added (5)
- [x] Code Block (syntax-highlighted, filename header, 12 languages)
- [x] Alert (info/success/warning/danger, dismissible)
- [x] Table (repeater-based, striped option)
- [x] Embed (generic HTML embed, aspect ratio)
- [x] Progress Circle (SVG, animated, configurable)

### Remaining
- [ ] Gallery: caption per image
- [ ] Blurb: icon picker UI
- [ ] Blog Posts (dynamic), Contact Form, Login, Search, Menu, Navigation

## Summary (as of ~1am MST)
- **422 tests, 841 assertions** — all passing
- **30 widgets** total (25 original + 5 new)
- **8 Alpine.js components** (added layupLightbox)
- **5 page templates** (blank, landing, about, contact, pricing)
- **Revision history** with auto-save and pruning
- **Full Design tab**: text color, alignment, font size, border, border radius, box shadow, opacity
- **Responsive visibility**: hide on any breakpoint
- **Entrance animations**: 6 types with configurable duration
- **SEO**: OG, Twitter, canonical, JSON-LD breadcrumbs, sitemap helper
