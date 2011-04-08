<?php

class FileUpload {
	public static function buildHash($filename) {
		$result = '';
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < 32; $i++)
			$result .= $chars[mt_rand(0, strlen($chars)-1)];
		$result .= '.'.pathinfo($filename, PATHINFO_EXTENSION);
		return $result;
	}

	public static function store($formFieldName, $destinationPath) {
		if (isset($_FILES[$formFieldName]) && isset($_FILES[$formFieldName]['error']) && ($_FILES[$formFieldName]['error'] == UPLOAD_ERR_OK)) {

			$filename = self::buildHash($_FILES[$formFieldName]['name']);

			$location = $destinationPath.$filename;
			if (move_uploaded_file($_FILES[$formFieldName]['tmp_name'], $location))
				return $filename;
		}
		return '';
	}

	public static function storeImage($formFieldName, $destinationPath, $width, $height, $keepAspectRatio = true) {
		$filename = self::store($formFieldName, $destinationPath);
		if ($filename != '') {
			require_once('Image.class.php');
			$image = new Image();
			$image->load($destinationPath.$filename);
			$image->resize($width, $height, $keepAspectRatio);
			$image->save();
		}
		return $filename;
	}

	public static function check($formFieldName, $extensions) {
		if (isset($_FILES[$formFieldName]) && isset($_FILES[$formFieldName]['error']) && ($_FILES[$formFieldName]['error'] == UPLOAD_ERR_OK) &&
		    in_array(pathinfo($_FILES[$formFieldName]['name'], PATHINFO_EXTENSION), $extensions))
			return true;

		return false;
	}
}

?>