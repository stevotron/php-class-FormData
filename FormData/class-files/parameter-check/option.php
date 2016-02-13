<?php

// the array key to locate the value to check is held in $parameter
$check = $this->setting_field[$parameter];

if (is_array($check)) {
	$clean = [];
	foreach ($check as $k => $v) {
		if (is_array($v)) {
			$id   = (string) $v[0];
			$desc = (string) $v[1];
		}
		else {
			$id   = (string) $k;
			$desc = (string) $v;
		}
		$clean[] = [$id, $desc];
	}
	$this->setting_field[$parameter] = $clean;
}
else {
	throw new Exception('Data for \'option\' for field name ('.$this->setting_field_name.'), must be an array');
}
