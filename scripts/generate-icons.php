<?php

// Raster companions to public/favicon.svg. Run: php scripts/generate-icons.php
function ritelIcon(int $size): string
{
    $scale = 8;
    $canvas = imagecreatetruecolor(64 * $scale, 64 * $scale);
    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);
    imagefill($canvas, 0, 0, imagecolorallocatealpha($canvas, 0, 0, 0, 127));
    $green = imagecolorallocate($canvas, 22, 118, 90);
    $white = imagecolorallocate($canvas, 255, 255, 255);
    $mint = imagecolorallocate($canvas, 142, 217, 180);
    imagefilledrectangle($canvas, 16 * $scale, 0, 48 * $scale, 64 * $scale - 1, $green);
    imagefilledrectangle($canvas, 0, 16 * $scale, 64 * $scale - 1, 48 * $scale, $green);
    foreach ([[16, 16], [48, 16], [16, 48], [48, 48]] as [$x, $y]) {
        imagefilledellipse($canvas, $x * $scale, $y * $scale, 32 * $scale, 32 * $scale, $green);
    }
    $points = [[16, 46], [16, 19], [26, 19], [26, 24]];
    foreach (range(1, 20) as $step) {
        $t = $step / 20; $u = 1 - $t;
        $points[] = [$u ** 3 * 26 + 3 * $u ** 2 * $t * 29 + 3 * $u * $t ** 2 * 32 + $t ** 3 * 38,
            $u ** 3 * 24 + 3 * $u ** 2 * $t * 20 + 3 * $u * $t ** 2 * 18 + $t ** 3 * 18];
    }
    $points[] = [38, 28];
    foreach (range(1, 20) as $step) {
        $t = $step / 20; $u = 1 - $t;
        $points[] = [$u ** 3 * 38 + 3 * $u ** 2 * $t * 30 + 3 * $u * $t ** 2 * 26 + $t ** 3 * 26,
            $u ** 3 * 28 + 3 * $u ** 2 * $t * 27 + 3 * $u * $t ** 2 * 30 + $t ** 3 * 38];
    }
    $points[] = [26, 46];
    $coordinates = [];
    foreach ($points as [$x, $y]) {
        $coordinates[] = (int) round($x * $scale);
        $coordinates[] = (int) round($y * $scale);
    }
    imagefilledpolygon($canvas, $coordinates, $white);
    imagefilledellipse($canvas, 45 * $scale, 42 * $scale, 10 * $scale, 10 * $scale, $mint);
    $output = imagecreatetruecolor($size, $size);
    imagealphablending($output, false);
    imagesavealpha($output, true);
    imagecopyresampled($output, $canvas, 0, 0, 0, 0, $size, $size, 64 * $scale, 64 * $scale);
    ob_start();
    imagepng($output);
    $png = ob_get_clean();
    imagedestroy($canvas);
    imagedestroy($output);

    return $png;
}

$public = dirname(__DIR__).'/public/';
file_put_contents($public.'apple-touch-icon.png', ritelIcon(180));
$sizes = [32, 64, 128];
$directory = ''; $images = ''; $offset = 6 + 16 * count($sizes);
foreach ($sizes as $size) {
    $png = ritelIcon($size);
    $directory .= pack('CCCCvvVV', $size, $size, 0, 0, 1, 32, strlen($png), $offset);
    $images .= $png;
    $offset += strlen($png);
}
file_put_contents($public.'favicon.ico', pack('vvv', 0, 1, count($sizes)).$directory.$images);
echo "Generated ritel. favicon.ico and apple-touch-icon.png\n";
