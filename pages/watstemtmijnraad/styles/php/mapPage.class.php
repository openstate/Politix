<?php

require_once('Image.class.php');

class mapPage {
	protected $foreground = 'color3';
	protected $background = 'bg_color';
	protected $filename = '/images/watstemtmijnraad/nederland.gif';

	public function show($smarty) {
		$style = Dispatcher::inst()->style;
		$fg = $this->stringToRGB($style->{$this->foreground});
		$bg = $this->stringToRGB($style->{$this->background});

		$img = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'].$this->filename);

		for ($i = 0; $i < imagecolorstotal($img); $i++) {
			$color = imagecolorsforindex($img, $i);
			$x = $color['red'];
			imagecolorset($img, $i,
				$this->interpolate($x, $fg[0], $bg[0]),
				$this->interpolate($x, $fg[1], $bg[1]), 
				$this->interpolate($x, $fg[2], $bg[2]));
		}

		header('Content-Type: image/gif');
		echo imagegif($img);
		die;
		
	}

	protected function interpolate($x, $fg, $bg) {
		return $bg + ($x / 255)*($fg - $bg);
	}

	protected function stringToRGB($string) {
		return array(hexdec(substr($string, 0, 2)),  hexdec(substr($string, 2, 2)), hexdec(substr($string, 4, 2)));
		
	}
}