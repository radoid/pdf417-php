<?php

namespace Radoid\PDF417\Tests\Renderers;

use Radoid\PDF417\BarcodeData;
use Radoid\PDF417\Renderers\JsonRenderer;
use PHPUnit\Framework\TestCase;

class JsonRendererTest extends TestCase
{
    public function testContentType()
    {
        $renderer = new JsonRenderer();
        $actual = $renderer->getContentType();
        $expected = "application/json";
        $this->assertSame($expected, $actual);
    }

    public function testRender()
    {
        $data = new BarcodeData();
        $data->codes = [
            [true, false],
            [false, true],
        ];

        $renderer = new JsonRenderer();
        $actual = $renderer->render($data);
        $expected = "[[1,0],[0,1]]";

        $this->assertSame($expected, $actual);
    }
}
