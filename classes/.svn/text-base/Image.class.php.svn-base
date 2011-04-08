<?php

require_once('Color.class.php');

class Image {
	const GIF = 1;
	const JPG = 2;
	const PNG = 3;
	const BMP = 6;

	protected $data = array(
		'type'     => '',
		'width'    => 0,
		'height'   => 0,
		'file'     => null,
		'image'    => null,
		'mimetype' => null
	);

	private $extensions = array(
		self::GIF => 'gif',
		self::JPG => 'jpg',
		self::PNG => 'png',
		self::BMP => 'bmp'
	);

	public function __construct($width = 0, $height = 0) {
		$this->data['width']  = $width;
		$this->data['height'] = $height;
		if ($width != 0 || $height != 0)
			$this->data['image'] = imagecreatetruecolor($width, $height);
	}

	public function __destruct() {
		@imagedestroy($this->data['image']);
	}

	public function load($fileName) {
		$properties = getimagesize($fileName);
		$this->data['width']    = $properties[0];
		$this->data['height']   = $properties[1];
		$this->data['type']     = $properties[2];
		$this->data['mimetype'] = $properties['mime'];
		$this->data['file']     = $fileName;

		switch ($this->data['type']) {
			case self::GIF: $this->data['image'] = imagecreatefromgif ($this->data['file']); break;
			case self::JPG: $this->data['image'] = imagecreatefromjpeg($this->data['file']); break;
			case self::PNG: $this->data['image'] = imagecreatefrompng ($this->data['file']); break;
			case self::BMP: $this->data['image'] = imagecreatefromwbmp($this->data['file']); break;
			default: throw new Exception('Unknown image type for file '.$fileName.': '.$this->data['type']);
		}
	}

	public function output($type = null) {
		if ($type === null)
			$type = $this->data['type'];
		if ($type === null)
			throw new Exception('No type given for outputting image.');
		switch ($type) {
			case self::GIF: return imagegif ($this->data['image']); break;
			case self::JPG: return imagejpeg($this->data['image']); break;
			case self::PNG: return imagepng ($this->data['image']); break;
			case self::BMP: return imagewbmp($this->data['image']); break;
		}
	}

	public function save() {
		switch ($this->data['type']) {
			case self::GIF: return imagegif ($this->data['image'], $this->data['file']); break;
			case self::JPG: return imagejpeg($this->data['image'], $this->data['file']); break;
			case self::PNG: return imagepng ($this->data['image'], $this->data['file']); break;
			case self::BMP: return imagewbmp($this->data['image'], $this->data['file']); break;
			default: return false; break;
		}
	}

	public function saveAs($file, $type, $appendExtension = false) {
		if ($appendExtension) $file .= '.'.$this->extensions[$type];

		switch ($type) {
			case self::GIF: $result = imagegif ($this->data['image'], $file); break;
			case self::JPG: $result = imagejpeg($this->data['image'], $file); break;
			case self::PNG: $result = imagepng ($this->data['image'], $file); break;
			case self::BMP: $result = imagewbmp($this->data['image'], $file); break;
			default: $result = false; break;
		}

		if ($result) {
			$this->data['file'] = $file;
			$this->data['type'] = $type;
		}

		return $result;
	}

	public function delete() {
		if ($this->data['file'])
			return unlink($this->data['file']);
		else
			return true;
	}

	public function copyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH) {
		if ($this->type == self::PNG) {
			if (function_exists('imageantialias'))
				imageantialias($dst, true);
			imagealphablending($dst, false);
			imagesavealpha($dst, true);
		}

		$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 0);
		imagefilledrectangle($dst, 0, 0, $dstW, $dstH, $transparent);

		imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);
	}

	public function resize($width, $height, $keepAspectRatio = true) {
		if ($keepAspectRatio && ($width == -1 && $height == -1))
			throw new Exception('When resizing with keeping aspect ratio, width or height must be given');
		else if (!$keepAspectRatio && ($width == -1 || $height == -1))
			throw new Exception('When resizing without keeping aspect ratio, both width and height must be given');

		if ($keepAspectRatio) {
			$ratio = $this->data['width'] / $this->data['height'];
			if ($width == -1)         // Auto-determine width
				$width = $height * $ratio;
			else if ($height == -1)   // Auto-determine height
				$height = $width / $ratio;
			else {                    // Fit within the width/height box
				$width = min($height * $ratio, $width);
				$height = min($width / $ratio, $height);
			}
		}

		$image = imagecreatetruecolor($width, $height);
		$this->copyresampled($image, $this->data['image'], 0, 0, 0, 0, $width, $height, $this->data['width'], $this->data['height']);

		@imagedestroy($this->data['image']);
		$this->data['image'] = $image;
		$this->data['width'] = $width;
		$this->data['height'] = $height;
	}

	public function rotate($angle, $bgcolor = -1) {
		$this->data['image'] = imagerotate($this->data['image'], $angle, $bgcolor);
	}

	public function crop($x, $y, $width, $height) {
		$image = imagecreatetruecolor($width, $height);
		$this->copyresampled($image, $this->data['image'], 0, 0, $x, $y, $width, $height, $width, $height);

		@imagedestroy($this->data['image']);
		$this->data['image'] = $image;
		$this->data['width'] = $width;
		$this->data['height'] = $height;
	}

	public function flipVertical() {
		$image = imagecreatetruecolor($this->data['width'], $this->data['height']);
		$this->copyresampled($image, $this->data['image'], 0, 0, 0, $this->data['height'] - 1, $this->data['width'], $this->data['height'], $this->data['width'], 0 - $this->data['height']);

		@imagedestroy($this->data['image']);
		$this->data['image'] = $image;
	}

	public function flipHorizontal() {
		$image = imagecreatetruecolor($this->data['width'], $this->data['height']);
		$this->copyresampled($image, $this->data['image'], 0, 0, $this->data['width'] - 1, 0, $this->data['width'], $this->data['height'], 0 - $this->data['width'], $this->data['height']);

		@imagedestroy($this->data['image']);
		$this->data['image'] = $image;
	}

	public function __get($name) {
		if (array_key_exists($name, $this->data))
			return $this->data[$name];
		else
			throw new Exception('Undefined property: '.get_class().'::$'.$name);
	}

	private function colorAt($x, $y) {
		$rgb = imagecolorat($this->data['image'], $x, $y);
		return array(($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF);
	}

	public function colorize($rgb) {
		$hls = Color::rgb2hls($rgb);
		for ($x = 0; $x < $this->data['width']; $x++) {
			for ($y = 0; $y < $this->data['height']; $y++) {
				list($h, $l, $s) = array_values(Color::rgb2hls($this->colorAt($x, $y)));
				list($r, $g, $b) = array_values(Color::hls2rgb($hls['h'], $l, $hls['s']));
				imagesetpixel($this->data['image'], $x, $y, imagecolorallocate($this->data['image'], $r, $g, $b));
			}
		}
	}

	public function sepia() {
		for ($x = 0; $x < $this->data['width']; $x++) {
			for ($y = 0; $y < $this->data['height']; $y++) {
				list($h, $l, $s) = array_values(Color::rgb2hls($this->colorAt($x, $y)));
				list($r, $g, $b) = array_values(Color::hls2rgb(0.30, $l, 0.25));
				imagesetpixel($this->data['image'], $x, $y, imagecolorallocate($this->data['image'], $r, $g, $b));
			}
		}
	}

	public function greyscale() {
		for ($x = 0; $x < $this->data['width']; $x++) {
			for ($y = 0; $y < $this->data['height']; $y++) {
				$rgbcolor = $this->colorAt($x, $y);
				$color = ($rgbcolor[0] + $rgbcolor[1] + $rgbcolor[2]) / 3;
				imagesetpixel($this->data['image'], $x, $y, imagecolorallocate($this->data['image'], $color, $color, $color));
			}
		}
	}

	public function threshold($level = 128) {
		$black = imagecolorallocate($this->data['image'], 0, 0, 0);
		$white = imagecolorallocate($this->data['image'], 255, 255, 255);
		for ($x = 0; $x < $this->data['width']; $x++) {
			for ($y = 0; $y < $this->data['height']; $y++) {
				$rgbcolor = $this->colorAt($x, $y);
				if (($rgbcolor[0] + $rgbcolor[1] + $rgbcolor[2]) / 3 < $level)
					imagesetpixel($this->data['image'], $x, $y, $black);
				else
					imagesetpixel($this->data['image'], $x, $y, $white);
			}
		}
	}

	// To maintain the image brightness, use a divisor equal to the sum of all values in the matrix
	// Lessen the effect of a filter by increasing the value in the center cell of the matrix
	public function convolution($matrix3x3, $divisor) {
		imageconvolution($this->data['image'], $matrix3x3, $divisor, 0);
	}

	// For a blur filter use a positive center value and surround it with a symmetrical pattern of other positive values
	public function blur() {
		$matrix = array(
			array(1,  1,  1),
			array(1, 16,  1),
			array(1,  1,  1)
		);
		$this->convolution($matrix, array_sum(array_map('array_sum', $matrix)));
	}

	// For a sharpen filter use a positive center value and surround it with a symmetrical pattern of negative values
	public function sharpen() {
		$matrix = array(
			array(-1, -1, -1),
			array(-1, 16, -1),
			array(-1, -1, -1)
		);
		$this->convolution($matrix, array_sum(array_map('array_sum', $matrix)));
	}

	// For an edge filter use a negative center value and surround it with a symmetrical pattern of positive values
	public function edge() {
		$matrix = array(
			array(1,  1,  1),
			array(1, -2,  1),
			array(1,  1,  1)
		);
		$this->convolution($matrix, array_sum(array_map('array_sum', $matrix)));
	}

	// For an emboss filter use a positive center value and surround it in a symmetrical pattern of negative values on one side and positive values on the other
	public function emboss() {
		$matrix = array(
			array(1,  1, -1),
			array(1,  1, -1),
			array(1, -1, -1)
		);
		$this->convolution($matrix, array_sum(array_map('array_sum', $matrix)));
	}
}

?>