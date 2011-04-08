<?php

class Validate {
	public static function is($value, $className) {
		try {
			require_once 'validate/'.$className.'.class.php';
			$class = new ReflectionClass('Validate_'.$className);
			if ($class->implementsInterface('Validate_Interface')) {
				$object = $class->newInstance();
				return $object->isValid($value);
			}
		} catch (Exception $e) {
			throw new Exception('Validate class not found');
		}
	}
}

?>