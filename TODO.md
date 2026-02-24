# Layup — Sprint TODO (overnight Feb 23-24)

## Priority 1: Testing (biggest gap)

### Frontend/HTTP Tests
- [ ] `tests/Feature/PageControllerTest.php` — GET routes return 200, 404 for missing slugs
- [ ] Test nested slug routing (`pages/about/team`)
- [ ] Test layout rendering (slot content appears)
- [ ] Test each widget type renders expected HTML structure
- [ ] Test `@layupScripts` directive outputs Alpine.data registrations
- [ ] Test disabled frontend routes (config toggle)

### SafelistCollector Tests
- [ ] `tests/Unit/SafelistCollectorTest.php` — staticClasses() returns expected count
- [ ] classesFromContent() extracts user custom classes
- [ ] classesFromContent() ignores empty content
- [ ] sync() dispatches SafelistChanged event on change
- [ ] sync() does NOT dispatch when hash unchanged
- [ ] toSafelistFile() output format

### Artisan Command Tests
- [ ] `tests/Feature/GenerateSafelistCommandTest.php` — writes file, --stdout, --static-only

### ContentValidator Tests (expand)
- [ ] Validate nested widget type checking in strict mode
- [ ] Validate malformed column spans
- [ ] Validate missing widget IDs

### Rendering Tests
- [ ] `tests/Unit/RenderingTest.php` — each widget renders without error
- [ ] Row renders with container class
- [ ] Column renders correct width classes from span
- [ ] Column gutters: first/middle/last get correct padding classes
- [ ] Full-width row skips container

## Priority 2: Missing Divi Features

### Sections (wraps rows)
- [ ] `Section` view component — outermost wrapper around rows
- [ ] Section settings: background image/video/gradient, parallax, fullscreen height
- [ ] Section form schema (Content/Design/Advanced tabs)
- [ ] Section blade template
- [ ] Update page content structure: `{ sections: [{ rows: [...] }] }`
- [ ] Migration path for existing content (wrap rows in default section)

### Design Tab Enhancements (per widget)
- [ ] Text color picker on BaseView design tab
- [ ] Font size selector (preset sizes or custom)
- [ ] Text alignment (left/center/right/justify)
- [ ] Border radius picker
- [ ] Border (width, style, color)
- [ ] Box shadow presets
- [ ] Opacity slider

### Hover States
- [ ] Hover color/transform options on buttons
- [ ] Hover effects on images (zoom, grayscale)

### Responsive Visibility
- [ ] Show/hide per breakpoint toggle on BaseView Advanced tab
- [ ] Generates `hidden md:block` type classes

### Animations/Transitions
- [ ] Entrance animations (fade in, slide up, etc.) via Alpine x-intersect
- [ ] Animation delay/duration options
- [ ] Add to BaseView Advanced tab

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
- [ ] Duplicate page action on PageResource list
- [ ] Page status badge (published/draft) in list
- [ ] Bulk actions (publish/unpublish/delete)
- [ ] Revision history (content versions)

## Priority 4: Portability & DX

### Export/Import
- [ ] Export page as JSON (action on EditPage)
- [ ] Import page from JSON (action on ListPages)
- [ ] Include widget type validation on import

### Page Templates
- [ ] Save current page layout as template
- [ ] Create page from template
- [ ] Ship default templates (landing page, about, contact, pricing)

### SEO Improvements
- [ ] Open Graph meta tags (og:title, og:description, og:image)
- [ ] Twitter Card meta tags
- [ ] Canonical URL
- [ ] Structured data (JSON-LD breadcrumbs)
- [ ] Sitemap integration hook

### Config & Extensibility
- [ ] `layup:install` artisan command (publish config, run migrations, print next steps)
- [ ] Widget discovery from app namespace (auto-register from `App\Layup\Widgets\`)
- [ ] Hook for custom safelist classes (event or config array)

## Priority 5: Widget Polish

### Existing Widgets — Missing Form Fields
- [ ] Text: text color, font size, alignment
- [ ] Heading: text color, font size override, alignment, link URL
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
