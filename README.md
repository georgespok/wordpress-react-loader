# WordPress React Loader Shortcode

A WordPress plugin that provides a shortcode to embed React applications on any page or post, theme-agnostic. This plugin allows you to easily integrate React apps into your WordPress site by simply using a shortcode.

## Features

- **Theme-agnostic**: Works with any WordPress theme
- **Multiple asset support**: Load multiple CSS and JavaScript files
- **Flexible mounting**: Customizable mount point ID
- **Security**: Properly escaped URLs and attributes
- **Performance**: Uses deferred script loading

## Installation

1. Upload the `react-loader.php` file to your WordPress plugins directory (`/wp-content/plugins/react-loader/`)
2. Activate the plugin through the WordPress admin panel
3. Use the shortcode in your posts or pages

## Usage

### Basic Example

```html
<!-- wp:shortcode -->
[reactloader base_url="<react build folder>/assets" js="index-B3wnHRwI.js" id="root"]
<!-- /wp:shortcode -->
```

### Advanced Example

```html
<!-- wp:shortcode -->
[reactloader base_url="https://example.com/react-app" js="main.js,vendor.js" css="styles.css" id="my-react-app"]
<!-- /wp:shortcode -->
```

## Shortcode Parameters

| Parameter | Required | Default | Description |
|-----------|----------|---------|-------------|
| `base_url` | No | Plugin assets directory | Base URL for your React app assets |
| `js` | Yes | - | Comma-separated list of JavaScript files to load |
| `css` | No | - | Comma-separated list of CSS files to load |
| `id` | No | `root` | ID for the mount point div |
| `mount_id` | No | `id` value | Alternative parameter for mount point ID |

## Examples

### Simple React App
```html
[reactloader js="app.js" id="react-container"]
```

### React App with CSS
```html
[reactloader base_url="/wp-content/uploads/react-app" js="index.js" css="styles.css" id="app-root"]
```

### Multiple JavaScript Files
```html
[reactloader js="vendor.js,app.js" css="vendor.css,app.css" id="main-app"]
```

### External CDN Assets
```html
[reactloader base_url="https://cdn.example.com/react-app" js="bundle.js" css="bundle.css" id="external-app"]
```

## How It Works

The plugin:

1. **Creates a mount point**: Generates a `<div>` with the specified ID where your React app will mount
2. **Loads CSS files**: Adds `<link>` tags for any specified CSS files
3. **Loads JavaScript files**: Adds `<script>` tags with `defer` attribute for JavaScript files
4. **Handles security**: Properly escapes URLs and attributes to prevent XSS attacks

## File Structure Example

For a typical React app build, your file structure might look like:

```
wp-content/uploads/react-app/
├── assets/
│   ├── index-B3wnHRwI.js
│   ├── index-B3wnHRwI.css
│   └── vendor.js
```

## Security Notes

- The plugin uses WordPress's built-in escaping functions (`esc_url`, `esc_attr`)
- Script tags are allowed in post content through KSES filter modification
- All URLs are validated and escaped before output

## Compatibility

- WordPress 5.0+
- Any WordPress theme
- React applications built with any bundler (Webpack, Vite, etc.)

## Version

Current version: 1.8.0

## License

GPLv2+
