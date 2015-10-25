<?php

// the array key to locate the value to check is held in $parameter
$check = $this->setting_field[$parameter];

if (is_array($check)) {
	$clean = [];
	foreach ($check as $k => $v) {
		if (is_array($v)) {
			$id   = $v[0];
			$desc = $v[1];
		}
		else {
			$id   = $k;
			$desc = $v;
		}
		$clean[] = [$id, $desc];
	}
	$this->setting_field[$parameter] = $clean;
}
else {
	throw new Exception('Data for \'option\' for field name ('.$this->setting_field_name.'), must be an array');
}
