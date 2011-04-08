<?php

require_once('Image.class.php');

class BgPage {
	public function show($smarty) {
		$img = new Image();
		$style = Dispatcher::inst()->style;
		try {
			@$img->load($_SERVER['DOCUMENT_ROOT'].'/files/'.$style->logo);
		} catch (Exception $e) {
			$img->load($_SERVER['DOCUMENT_ROOT'].'/files/wsmr.gif');
		}

		$bg = imagecreate(950, 1);
		
		$bgc = $this->stringToRGB($style->bg_color);
		$bg_color = imagecolorallocate($bg, $bgc[0], $bgc[1], $bgc[2]);
		$c6 = $this->stringToRGB($style->color6);
		$color6 = imagecolorallocate($bg, $c6[0], $c6[1], $c6[2]);
		$lgrey = imagecolorallocate($bg, 237, 237, 237);
		$c5 = $this->stringToRGB($style->color5);
		$color5 = imagecolorallocate($bg, $c5[0], $c5[1], $c5[2]);
		
		imageline($bg, 1, 0, $img->width, 0, $color6);
		imageline($bg, 715, 0, 719, 0, $lgrey);
		imageline($bg, 925, 0, 929, 0, $color5);
		
		header('Content-type: image/png');
		echo imagepng($bg); die;
	}

	private function stringToRGB($string) {
		return array(hexdec(substr($string, 0, 2)),
								 hexdec(substr($string, 2, 2)),
								 hexdec(substr($string, 4, 2)));
		
	}
}