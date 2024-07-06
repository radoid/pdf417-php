<?php

namespace BigFish\PDF417\Tests\Renderers;

use BigFish\PDF417\BarcodeData;
use BigFish\PDF417\Renderers\ImageRenderer;
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

    
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "scale": "0".
     */
    public function testInvalidScale()
    {
        new ImageRenderer(["scale" => 0]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "ratio": "0".
     */
    public function testInvalidRatio()
    {
        new ImageRenderer(["ratio" => 0]);
    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "padding": "-1".
     */
    public function testInvalidPadding()
    {
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
}
