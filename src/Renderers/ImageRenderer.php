<?php

namespace BigFish\PDF417\Renderers;

use BigFish\PDF417\BarcodeData;

class ImageRenderer extends AbstractRenderer
{
    protected $options = [
        'scale' => 3,
        'ratio' => 3,
        'padding' => 20,
    ];

    /**
     * {@inheritdoc}
     */
    public function validateOptions()
    {
        $errors = [];

        $scale = $this->options['scale'];
        if (!is_numeric($scale) || $scale < 1 || $scale > 20) {
            $errors[] = "Invalid option \"scale\": \"$scale\". Expected an integer between 1 and 20.";
        }

        $ratio = $this->options['ratio'];
        if (!is_numeric($ratio) || $ratio < 1 || $ratio > 10) {
            $errors[] = "Invalid option \"ratio\": \"$ratio\". Expected an integer between 1 and 10.";
        }

        $padding = $this->options['padding'];
        if (!is_numeric($padding) || $padding < 0 || $padding > 50) {
            $errors[] = "Invalid option \"padding\": \"$padding\". Expected an integer between 0 and 50.";
        }

        return $errors;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return 'image/png';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function render(BarcodeData $data)
    {
        $pixelGrid = $data->getPixelGrid();
        $height = count($pixelGrid);
        $width = count($pixelGrid[0]);

        // Extract options
        $padding = $this->options['padding'];
        $ratio = $this->options['ratio'];
        $scale = $this->options['scale'];

        // Create a new image
        $image = imagecreate($width * $scale + 2*$padding, $height * $scale * $ratio + 2*$padding);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);

        // Render the barcode
        foreach ($pixelGrid as $y => $row) {
            foreach ($row as $x => $value) {
                if ($value) {
                    imagefilledrectangle($image, $padding + $x * $scale, $padding + $y * $scale * $ratio, $padding + ($x + 1) * $scale - 1, $padding + ($y + 1) * $scale * $ratio - 1, $black);
                }
            }
        }

        // Output the image into blob
        ob_start();
        imagepng($image);
        $blob = ob_get_clean();

        return $blob;
    }
}
