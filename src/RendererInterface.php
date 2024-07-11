<?php

namespace Radoid\PDF417;

interface RendererInterface
{
    public function render(BarcodeData $data);
}
