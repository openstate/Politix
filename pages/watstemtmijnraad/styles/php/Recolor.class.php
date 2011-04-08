<?php

require_once('Image.class.php');

class Recolor {
	protected $foreground;
	protected $background;
	protected $filename;

	public function show($smarty) {
		$style = Dispatcher::inst()->style;
		$foreground = $this->stringToRGB($style->{$this->foreground});
		$background = $this->stringToRGB($style->{$this->background});

		$img = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$this->filename);

		for($x = 0; $x < imagesx($img); $x++)
			for($y = 0; $y < imagesy($img); $y++) {
				$rgba = imagecolorat($img, $x, $y);
				$c[0] = ($rgba >> 16) & 0xFF;
				$c[1] = ($rgba >> 8) & 0xFF;
				$c[2] = $rgba & 0xFF;
				$a = $rgba >> 24;
				foreach ($c as $i => $col)
					$c[$i] = (int) (min(255, ($foreground[$i] * $c[$i] / 255)) * (127-$a) / 127 + ($background[$i]) * $a / 127);
				$color = imagecolorallocate($img, $c[0], $c[1], $c[2]);
				imagesetpixel($img, $x, $y, $color);
			}

		header('Content-Type: image/png');
		echo imagepng($img);
		die;
		
	}

	protected function stringToRGB($string) {
		return array(hexdec(substr($string, 0, 2)),
								 hexdec(substr($string, 2, 2)),
								 hexdec(substr($string, 4, 2)));
		
	}
}