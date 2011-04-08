<?php

require_once('Image.class.php');

class StripesPage {
	protected $defaultHsv = array(
		0 => array(78, 0.47, 0.85),
		1 => array(50, 0.48, 0.93),
		2 => array(52, 1.00, 1.00),
		3 => array(186, 0.85, 0.78),
		4 => array(103, 0.85, 0.77),
		5 => array(350, 0.73, 1.00)
	);

	public function show($smarty) {
		header('Content-Type: image/gif');

		$style = Dispatcher::inst()->style;
		$default = Style::getDefault();
		$filename = $_SERVER['DOCUMENT_ROOT'].'/images/watstemtmijnraad/bg_streepjes.gif';

		if ($default->color2 == $style->color2) {
			readfile($filename);
			die;
		}

		$img = imagecreatefromgif($filename);

		$main = $this->rgb2hsv($this->stringToRGB($style->color2));
		foreach($this->defaultHsv as $key => $hsv) {
			$h = $this->real_modulus($hsv[0] + $main[0] - $this->defaultHsv[5][0], 360);
			$s = min(1, max(0, $hsv[1] * $main[1] / $this->defaultHsv[5][1]));
			$v = min(1, max(0, $hsv[2] * $main[2] / $this->defaultHsv[5][2]));
			$rgb = $this->hsv2rgb(array($h, $s, $v));
			imagecolorset($img, $key, $rgb[0], $rgb[1], $rgb[2]);
		}
		
		echo imagegif($img);
		die;
		
	}

	protected function stringToRGB($string) {
		return array(hexdec(substr($string, 0, 2)),
								 hexdec(substr($string, 2, 2)),
								 hexdec(substr($string, 4, 2)));
		
	}

	protected function rgb2hsv($rgb) {
		$max = max($rgb); $min = min($rgb);
		return array(
			(int) ($max == $min ? 0 :
				($max == $rgb[0] ? $this->real_modulus(60 * ($rgb[1] - $rgb[2]) / ($max - $min), 360) :
				($max == $rgb[1] ? 60 * ($rgb[2] - $rgb[0]) / ($max - $min) + 120 :
				                   60 * ($rgb[0] - $rgb[1]) / ($max - $min) + 240))),
			$max == 0 ? 0 : ($max - $min) / $max,
			$max / 255 
		);
	}

	protected function hsv2rgb($hsv) {
		$h = $this->real_modulus((int) ($hsv[0] / 60.0), 6);
		$f = $hsv[0] / 60.0 - (int) ($hsv[0] / 60);
		$p = (int) ($hsv[2] * (1 - $hsv[1]) * 255);
		$q = (int) ($hsv[2] * (1 - $f * $hsv[1]) * 255);
		$t = (int) ($hsv[2] * (1 - (1 - $f) * $hsv[1]) * 255);
		$v = (int) ($hsv[2] * 255);
		switch ($h) {
			case 0: return array($v, $t, $p);
			case 1: return array($q, $v, $p);
			case 2: return array($p, $v, $t);
			case 3: return array($p, $q, $v);
			case 4: return array($t, $p, $v);
			case 5: return array($v, $p, $q);
		}
	}

	protected function real_modulus($a, $b) {
		return $a % $b < 0 ? $a % $b + $b : $a % $b;
	}
}