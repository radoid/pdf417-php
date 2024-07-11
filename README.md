PDF 417 barcode generator
=========================

This is a fork of the [ihabunek/pdf417-php](https://github.com/ihabunek/pdf417-php/) library,
having the Intervention Image library removed for simplicity.
It now relies on the PHP native GD extension only.
Unneeded configuration options are also removed:
bitmap image types (other than PNG) and colors (other than black on white).

Requirements
------------

Requires the following components:

* PHP >= 5.5
* PHP extensions: bcmath, gd

Installation
------------

Add it to your `composer.json` file:

```
composer require radoid/pdf417
```

Usage overview
--------------

```php
require 'vendor/autoload.php';

use Radoid\PDF417\PDF417;
use Radoid\PDF417\Renderers\ImageRenderer;
use Radoid\PDF417\Renderers\SvgRenderer;

// Text to be encoded into the barcode
$text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur
imperdiet sit amet magna faucibus aliquet. Aenean in velit in mauris imperdiet
scelerisque. Maecenas a auctor erat.';

// Encode the data, returns a BarcodeData object
$pdf417 = new PDF417();
$data = $pdf417->encode($text);

// Create a PNG image
$renderer = new ImageRenderer();
$image = $renderer->render($data);

// Create an SVG image
$renderer = new SvgRenderer();
$svg = $renderer->render($data);

// Create a data URL
$dataURL = $renderer->renderDataUrl($data);

// Use custom options
$options = [
	'scale' => 3,
	'ratio' => 2,
	'padding' => 0,
]
$renderer = new ImageRenderer($options);
```

### Options available

| Option    | Default | Description                                       |
|-----------|---------|---------------------------------------------------|
| `scale`   | 3       | Scale of barcode elements (1-20)                  |
| `ratio`   | 3       | Height to width ration of barcode elements (1-10) |
| `padding` | 20      | Padding in pixels (0-50)                          |
