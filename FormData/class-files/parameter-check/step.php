<?php

// the array key to locate the value to check is held in $parameter
$check = $this->setting_field[$parameter];

if ($check !== 'any') {
	$check = (float) $check;
}

if ($check !== 'any' && $check <= 0) {
	throw new Exception('Invalid value ('.$check.') for field name ('.$this->setting_field_name.'), parameter ('.$parameter.') - must be positive float or string "any"');
}
