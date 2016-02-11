<?php

// $name is field name to check
// $input is submitted data

// params
$required = $this->field[$name]['required'];
$min      = $this->field[$name]['min'];
$max      = $this->field[$name]['max'];
$step     = $this->field[$name]['step'];
$decimal  = $this->field[$name]['decimal'];

// store original input
$this->field[$name]['value'] = $input;

$input = preg_replace("|\s|",'',$input);
$input = preg_replace("|\A00+\z|", '0', $input);
if ($input != '0') {
	$input = trim($input,'0');
}

$decCheck = explode('.', $input);

if ($input == '' && $required == '1') {
	$this->setError($name, 'is required');
}
else if (!preg_match("|\A\-?[0-9]*\.?[0-9]*\z|",$input) || $input < $min || $input > $max) {
	// make error message relevant to number parameters
	$suf = $decimal > 0 ? (', up to '.$decimal.' decimal place'.($decimal == '1' ? '' : 's')) : '';
	$this->setError($name, 'must be between '.$min.' and '.$max.$suf);
}
else if (strlen($decCheck[1]) > $decimal) {
	if ($decimal == '0') {
		$this->setError($name, 'cannot be decimal');
	}
	else {
		$this->setError($name, 'must be no more than '.$decimal.' decimal place'.($decimal == '1' ? '' : 's'));
	}
}
else if ($step != 'any' && fmod($min, $step) == 0 && fmod($input, $step) != 0) {
	// step was incorrect - minimum value CAN be cleanly divided by step
	$this->setError($name, 'must be divisible by '.$step);
}
else if ($step != 'any' && fmod($min, $step) != 0 && fmod($input - $min, $step) != 0) {
	// step was incorrect - minimum value CANNOT be cleanly divided by step
	$this->setError($name, 'must be in steps of '.$step.', starting at '.$min);
}
else {
	$this->field[$name]['valueclean'] = $input;
}
