<?php
// TODO : logs, docs, exceptions
class CSV {

	/*
		Method: read
		Reads a comma seperated values file.

		Parameters:
		$file      - The CSV file to read.
		$seperator - Character that seperates the values.

		Returns:
		An 2-dimensional array containing the values per row.
	*/
	public static function read($file, $seperator = ',') {
		if (!file_exists($file)) throw new FileNotFoundException($file);

		$fp = fopen($file, 'r');
		if (!$fp) throw new FileNotReadableException($file);

		$result = array();
		$index = 1;
		$count = 0;

		while ($row = fgetcsv($fp, 0, $seperator)) {
			if (reset($row) != NULL) {
				if ($index == 1) {
					$count = count($row);
					$result[] = $row;
				} elseif (count($row) == $count) {
					$result[] = $row;
				} else {
					throw new InvalidCSVException($fp);
				}
				$index++;
			}
		}
		fclose($fp);

		return $result;
	}

	/*
		Method: write
		Writes a 2-dimensional array to a comma seperated values file.

		Parameters:
		$file      - The file to write to.
		$fields    - The input array.
		$seperator - Seperation character.
	*/
	public static function write($file, $fields, $seperator = ',') {
		$fp = fopen($file, 'w');
		if (!$fp) throw new FileNotWritableException($file);

		foreach ($fields as $row) {
			fputcsv($fp, $row, $seperator);
		}

		fclose($fp);
	}

	/*
		Method: download
		Creates a comma seperated values file and presents it as a downloadable file.

		Parameters:
		$fields     - The 2-dimensional input array containing the values.
		$seperator  - Character that seperates the values.
		$attachment - Whether the download should be presented as an attachment.
	*/
	public static function download($filename, $fields, $seperator = ',', $attachment = false) {
		header('Content-Type:        application/csv');
		header('Pragma:              cache');
		header('Cache-Control:       public, must-revalidate, max-age=0');
		header('Connection:          close');
		if ($attachment) header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
		header('Accept-Ranges:       bytes');

		CSV::write('php://output', $fields, $seperator);
		die;
	}

	public static function translate($header, $fields, array $colNames, array $colValues, $poFile) {
		require_once('GettextPO.class.php');

		if (!is_array($poFile))
			$poFile = array($poFile);

		$pos = array();
		foreach ($poFile as $po) {
			$sourcePath = preg_replace('!([\\\\/]pages[\\\\/].*?[\\\\/])[^\\\\/]+[\\\\/]?$!', '/locale$1', realpath(dirname($po)));
			$file = basename($po).'.'.Request::inst()->locale.'.po';
			if (file_exists($sourcePath.$file))
				$po = new GettextPO($sourcePath.$file);
			else if (file_exists($_SERVER['DOCUMENT_ROOT'].'/../locale/'.$file))
				$po = new GettextPO($_SERVER['DOCUMENT_ROOT'].'/../locale/'.$file);
			else
				throw new Exception('Cannot load file '.$file);
			$pos[]= $po;
		}

		foreach ($colValues as &$cv) {
			foreach ($cv as &$el) {
				foreach ($pos as $po) {
					if ($str = $po->getMsgStr($el)) {
						$el = $str;
						break;
					}
				}
			}
		}
		unset($cv);

		$result = array();
		foreach ($colNames as $name) {
			foreach ($pos as $po) {
				if ($str = $po->getMsgStr($name)) {
					$result[0][]= $str;
					break;
				}
				$result[0][]= $name;
			}
		}
		foreach ($fields as $row) {
			$rrow = array_intersect_key($row, $colNames);
			foreach ($colValues as $col => $cv)
				$rrow[$col] = $cv[$rrow[$col]];
			$result[]= $rrow;
		}

		return array('filename' => $po->getMsgStr($header).strftime(' - %Y-%m-%d'), 'fields' => $result);
	}
}
?>