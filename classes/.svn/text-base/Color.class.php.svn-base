<?php

class Color {
	public static function rgb2hsl() {
		$args = func_get_args();
		if (count($args) == 3)
			list($r, $g, $b) = $args;
		elseif (count($args) == 1)
			list($r, $g, $b) = array_values($args[0]);
		else
			throw new Exception('rgb2hls:: Invalid parameters');

		$r /= 255; $g /= 255; $b /= 255;

		$max = max($r,$g,$b);
		$min = min($r,$g,$b);

		list($h, $s, $l) = array(0, 0, ($max + $min) / 2);

		$rng = $max - $min;

		if ($rng != 0) {
			$s = ($l <= 0.5) ? ($rng / ($max + $min)) : ($rng / (2 - ($max + $min)));

			if ($r == $max) $h = ($g - $b) / $rng;
			elseif ($g == $max) $h = 2 + ($b - $r) / $rng;
			else $h = 4 + ($r - $g) / $rng;
			$h *= 60;

			if ($h < 0) $h += 360;
			if ($h > 360) $h -= 360;
		}
	
		return array('h' => round($h), 's' => round($s, 2), 'l' => round($l, 2));
	}

	public function hsl2rgb() {
		$args = func_get_args();
		if (count($args) == 3)
			list($h, $s, $l) = $args;
		elseif (count($args) == 1)
			list($h, $s, $l) = array_values($args[0]);
		else
			throw new Exception('hls2rgb:: Invalid parameters');

		list($r, $g, $b) = array(0, 0, 0);

		if ($s == 0) {
			$r = $g = $b = $l;
		} else {
			$max = ($l <= 0.5) ? ($l * (1 + $s)) : ($l + $s * (1 - $l));
			$min = 2 * $l - $max;

			$r = Color::hue2rgb($min, $max, $h + 120);
			$g = Color::hue2rgb($min, $max, $h);
			$b = Color::hue2rgb($min, $max, $h - 120);
		}

		return array('r' => round($r * 255), 'g' => round($g * 255), 'b' => round($b * 255));
	}

	public static function hue2rgb($min, $max, $h) {
		if ($h < 0) $h += 360;
		if ($h > 360) $h -= 360;

		if ($h < 60) return $min + ($max - $min) * $h / 60;
		elseif ($h < 180) return $max;
		elseif ($h < 240) return $min + ($max - $min) * (240 - $h) / 60;
		else return $min;
	}

	public static function rgb2hex() {
		$args = func_get_args();
		if (count($args) == 3)
			list($r, $g, $b) = $args;
		elseif (count($args) == 1)
			list($r, $g, $b) = array_values($args[0]);
		else
			throw new Exception('rgb2hex:: Invalid parameters');

		return '#'.sprintf('%02X', $r).sprintf('%02X', $g).sprintf('%02X', $b);
	}

	public static function hex2rgb($hex) {
		if ($hex[0] == '#') $hex = substr($hex, 1);
		$hex = hexdec($hex);
		return array('r' => $hex >> 16, 'g' => ($hex >> 8) & 0xFF, 'b' => $hex & 0xFF);
	}

	public static function gradient($begin, $end, $n) {
		$gradient = array($begin);

		list($br, $bg, $bb) = array_values(self::hex2rgb($begin));
		list($er, $eg, $eb) = array_values(self::hex2rgb($end));

		$dr = ($br - $er) / ($n + 1);
		$dg = ($bg - $eg) / ($n + 1);
		$db = ($bb - $eb) / ($n + 1);

		while ($n > 0) {
			$gradient[] = self::rgb2hex(round($br -= $dr), round($bg -= $dg), round($bb -= $db));
			$n--;
		}

		$gradient[] = $end;
		return $gradient;
	}

	public static function reflectedgradient($begin, $middle, $n) {
		$gradient = self::lineargradient($begin, $middle, $n/2);
		return array_merge($gradient, array_reverse(array_slice($gradient, 0, count($gradient) - 1)));
	}
}

?>