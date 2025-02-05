<?php

namespace Radoid\PDF417\Tests\Renderers;

use Radoid\PDF417\BarcodeData;
use Radoid\PDF417\Renderers\ImageRenderer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ImageRendererTest extends TestCase
{
    public function testContentType()
    {
        $renderer = new ImageRenderer();
        $actual = $renderer->getContentType();
        $expected = "image/png";
        $this->assertSame($expected, $actual);
    }

    public function testInvalidScale()
    {
		$this->expectException(InvalidArgumentException::class);
        new ImageRenderer(["scale" => 0]);
    }

    public function testInvalidRatio()
    {
		$this->expectException(InvalidArgumentException::class);
        new ImageRenderer(["ratio" => 0]);
    }
	
    public function testInvalidPadding()
    {
		$this->expectException(InvalidArgumentException::class);
        new ImageRenderer(["padding" => -1]);
    }

    public function testRenderPNG()
    {
        $data = new BarcodeData();
        $data->codes = [[true, false],[false, true]];

        $scale = 4;
        $ratio = 5;
        $padding = 6;

        $renderer = new ImageRenderer([
            'scale' => $scale,
            'ratio' => $ratio,
            'padding' => $padding
        ]);

        $png = $renderer->render($data);
	    $image = imagecreatefromstring($png);

        // Expected dimensions
        $width = 2 * $padding + 2 * $scale;
        $height = 2 * $padding + 2 * $scale * $ratio;

        $this->assertSame($width, imagesx($image));
        $this->assertSame($height, imagesy($image));

    }

    public function testRenderDataUrl()
    {
        $data = new BarcodeData();
        $data->codes = [[true, false],[false, true]];
        $renderer = new ImageRenderer();
        $url = $renderer->renderDataUrl($data);

        $this->assertStringStartsWith('data:image/png;base64,', $url);
    }
}
