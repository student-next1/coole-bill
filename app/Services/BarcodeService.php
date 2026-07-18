<?php

namespace App\Services;

use Picqer\Barcode\Barcode;

class BarcodeService
{
    /**
     * Generate barcode as PNG image
     */
    public static function generateBarcodePNG($data, $format = 'C128', $width = 2, $height = 30)
    {
        $barcode = new Barcode($data, $format);
        $barcode->setWidth($width);
        $barcode->setHeight($height);
        
        return $barcode->getPngData();
    }

    /**
     * Generate barcode SVG
     */
    public static function generateBarcodeSVG($data, $format = 'C128')
    {
        $barcode = new Barcode($data, $format);
        return $barcode->getSVG(2, 30);
    }

    /**
     * Generate base64 encoded PNG for inline display
     */
    public static function generateBarcodeBase64($data, $format = 'C128')
    {
        $pngData = self::generateBarcodePNG($data, $format);
        return 'data:image/png;base64,' . base64_encode($pngData);
    }

    /**
     * Generate QR Code (using simple text representation)
     * Note: For real QR codes, use endroid/qr-code package
     */
    public static function generateQRCodeASCII($data)
    {
        // Simplified ASCII QR representation
        // For production, use: composer require endroid/qr-code
        return $data;
    }
}
