<?php

// $name is field name to check
// $input is submitted data


// params
$required = $this->field[$name]['required'];
$min      = $this->field[$name]['min'];
$max      = $this->field[$name]['max'];
$step     = $this->field[$name]['step'];


// store original input
$this->field[$name]['value'] = $input;


// work out max decimal places
$a = explode('.', $step);
if (isset($a[1])) {
	$max_decimal = strlen($a[1]);
}
else {
	$max_decimal = 0;
}


// primary clean
$input = preg_replace("|\s|",'',$input);


// initial checks
if (!preg_match("~\A\-?[0-9]*(\.[0-9]+)?\z~",$input)) {
	$this->setError($name, 'must be numerical');
}
else {
	// secondary clean
	$input = (float) $input;

	// count decimal places
	$a = explode('.', $input);
	$decimal_places = strlen($a[1]);

	// further checks
	if ($input == '' && $required == '1') {
		$this->setError($name, 'is required');
	}
	else if ($input < $min || $input > $max) {
		$this->setError($name, 'must be between '.$min.' and '.$max);
	}
	else if ($decimal_places > $max_decimal) {
		if ($max_decimal == '0') {
			$this->setError($name, 'cannot be decimal');
		}
		else {
			$this->setError($name, 'must be no more than '.$max_decimal.' decimal place'.($max_decimal == '1' ? '' : 's'));
		}
	}
	else if ($step != 'any' && round(fmod($min, $step),14) == 0 && round(fmod($input, $step),14) != 0) {
		// step was incorrect - minimum value CAN be cleanly divided by step
		$this->setError($name, 'must be multiple of '.$step);
	}
	else if ($step != 'any' && round(fmod($min, $step),14) != 0 && round(fmod($input - $min, $step),14) != 0) {
		// step was incorrect - minimum value CANNOT be cleanly divided by step
		$this->setError($name, 'must be in steps of '.$step.', starting at '.$min);
	}
	else {
		$this->field[$name]['valueclean'] = $input;
	}
}
