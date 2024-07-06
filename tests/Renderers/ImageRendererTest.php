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

        $renderer = new ImageRenderer(["format" => "png"]);
        $actual = $renderer->getContentType();
        $expected = "image/png";
        $this->assertSame($expected, $actual);

        $renderer = new ImageRenderer(["format" => "jpg"]);
        $actual = $renderer->getContentType();
        $expected = "image/jpeg";
        $this->assertSame($expected, $actual);

        $renderer = new ImageRenderer(["format" => "gif"]);
        $actual = $renderer->getContentType();
        $expected = "image/gif";
        $this->assertSame($expected, $actual);

        $renderer = new ImageRenderer(["format" => "bmp"]);
        $actual = $renderer->getContentType();
        $expected = "image/bmp";
        $this->assertSame($expected, $actual);

        $renderer = new ImageRenderer(["format" => "tif"]);
        $actual = $renderer->getContentType();
        $expected = "image/tiff";
        $this->assertSame($expected, $actual);

        // data-url format does not have a mime type
        $renderer = new ImageRenderer(["format" => "data-url"]);
        $actual = $renderer->getContentType();
        $this->assertNull($actual);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "format": "foo".
     */
    public function testInvalidFormat()
    {
        new ImageRenderer(["format" => "foo"]);
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

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "color": "red".
     */
    public function testInvalidColor()
    {
        new ImageRenderer(["color" => "red"]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "bgColor": "red".
     */
    public function testInvalidBgColor()
    {
        new ImageRenderer(["bgColor" => "red"]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid option "quality": "101".
     */
    public function testInvalidQuality()
    {
        new ImageRenderer(["quality" => 101]);
    }

    public function testRenderPNG()
    {
        $data = new BarcodeData();
        $data->codes = [[true, false],[false, true]];

        $scale = 4;
        $ratio = 5;
        $padding = 6;

        $renderer = new ImageRenderer([
            'format' => 'png',
            'scale' => $scale,
            'ratio' => $ratio,
            'padding' => $padding
        ]);


        $png = $renderer->render($data);
	    $image = imagecreatefromstring($png);

        // Expected dimensions
        $width = 2 * $padding + 2 * $scale;
        $height = 2 * $padding + 2 * $scale * $ratio;
        $mime = "image/png";

        $this->assertSame($width, imagesx($image));
        $this->assertSame($height, imagesy($image));

    }
}
