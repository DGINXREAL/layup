# Layup — Sprint TODO (overnight Feb 23-24)

## Priority 1: Testing (biggest gap)

### Frontend/HTTP Tests
- [x] `tests/Feature/PageControllerTest.php` — GET routes return 200, 404 for missing slugs
- [x] Test nested slug routing (`pages/about/team`)
- [x] Test layout rendering (slot content appears)
- [x] Test each widget type renders expected HTML structure
- [x] Test `@layupScripts` directive outputs Alpine.data registrations
- [x] Test disabled frontend routes (config toggle)

### SafelistCollector Tests
- [x] `tests/Unit/SafelistCollectorTest.php` — staticClasses() returns expected count
- [x] classesFromContent() extracts user custom classes
- [x] classesFromContent() ignores empty content
- [x] sync() dispatches SafelistChanged event on change
- [x] sync() does NOT dispatch when hash unchanged
- [x] toSafelistFile() output format

### Artisan Command Tests
- [x] `tests/Feature/GenerateSafelistCommandTest.php` — writes file, --stdout, --static-only

### ContentValidator Tests (expand)
- [x] Validate nested widget type checking in strict mode
- [x] Validate malformed column spans (non-array rows/columns/widgets)
- [x] Validate missing widget IDs (empty type string)

### Rendering Tests
- [x] `tests/Unit/RenderingTest.php` — each widget renders without error
- [x] Row renders with container class
- [x] Column renders correct width classes from span
- [x] Column gutters: first/middle/last get correct padding classes
- [x] Full-width row skips container

## Priority 2: Missing Divi Features

### Sections (wraps rows)
- [ ] `Section` view component — outermost wrapper around rows
- [ ] Section settings: background image/video/gradient, parallax, fullscreen height
- [ ] Section form schema (Content/Design/Advanced tabs)
- [ ] Section blade template
- [ ] Update page content structure: `{ sections: [{ rows: [...] }] }`
- [ ] Migration path for existing content (wrap rows in default section)

### Design Tab Enhancements (per widget)
- [x] Text color picker on BaseView design tab
- [x] Font size selector (preset sizes or custom)
- [x] Text alignment (left/center/right/justify)
- [x] Border radius picker
- [x] Border (width, style, color)
- [x] Box shadow presets
- [ ] Opacity slider

### Hover States
- [ ] Hover color/transform options on buttons
- [ ] Hover effects on images (zoom, grayscale)

### Responsive Visibility
- [x] Show/hide per breakpoint toggle on BaseView Advanced tab
- [x] Generates `hidden md:block` type classes

### Animations/Transitions
- [x] Entrance animations (fade in, slide up, etc.) via Alpine x-intersect
- [x] Animation delay/duration options
- [x] Add to BaseView Advanced tab

## Priority 3: Builder UX Polish

### Widget Picker
- [ ] Widget icons render in picker modal (currently just text labels)
- [ ] Recently used widgets section
- [ ] Drag from picker to canvas

### Builder Canvas
- [ ] Live preview of widget content (not just getPreview() text)
- [ ] Inline text editing for Text/Heading widgets
- [ ] Visual column resize handles

### Page Management
- [x] Duplicate page action on PageResource list
- [x] Page status badge (published/draft) in list
- [x] Bulk actions (publish/unpublish/delete)
- [ ] Revision history (content versions)

## Priority 4: Portability & DX

### Export/Import
- [x] Export page as JSON (action on EditPage)
- [x] Import page from JSON (action on ListPages)
- [x] Include widget type validation on import

### Page Templates
- [ ] Save current page layout as template
- [ ] Create page from template
- [ ] Ship default templates (landing page, about, contact, pricing)

### SEO Improvements
- [x] Open Graph meta tags (og:title, og:description, og:image)
- [x] Twitter Card meta tags
- [x] Canonical URL
- [ ] Structured data (JSON-LD breadcrumbs)
- [ ] Sitemap integration hook

### Config & Extensibility
- [x] `layup:install` artisan command (publish config, run migrations, print next steps)
- [ ] Widget discovery from app namespace (auto-register from `App\Layup\Widgets\`)
- [ ] Hook for custom safelist classes (event or config array)

## Priority 5: Widget Polish

### Existing Widgets — Missing Form Fields
- [x] Text: text color, font size, alignment (via BaseView Design tab)
- [x] Heading: link URL added to Content tab
- [ ] Button: icon (left/right), border radius, custom colors
- [ ] Image: link URL, link target, border radius, hover effect
- [ ] Video: poster image, privacy-enhanced mode
- [ ] Blurb: icon picker (when media_type=icon), text alignment
- [ ] CTA: background color/gradient, text color, button style options
- [ ] Testimonial: star rating, company name
- [ ] Pricing Table: annual/monthly toggle, custom badge text
- [ ] Social Follow: icon size, color overrides per network
- [ ] Map: custom marker, satellite/terrain toggle
- [ ] Gallery: lightbox JS implementation, caption per image

### New Widgets to Consider
- [ ] Blog Posts (dynamic — pulls from model)
- [ ] Contact Form (simple mailto or integration hook)
- [ ] Login / Signup form
- [ ] Search
- [ ] Menu / Navigation
- [ ] Alert / Notice bar
- [ ] Progress circle
- [ ] Code block (syntax highlighted)
- [ ] Embed (generic oEmbed)
- [ ] Table (simple data table)
