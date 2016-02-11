<?php

// $name is field name to check
// $input is submitted data

// params
$required = $this->field[$name]['required'];

// store original input
$this->field[$name]['value'] = $input;


// set the value we are looking for
$correct = $this->field[$name]['checkboxvalue'] === NULL ? '1' : $this->field[$name]['checkboxvalue'];

if ($input == $correct) {
	$this->field[$name]['valueclean'] = $correct;
}
else if ($required == '1') {
	$this->setError($name, 'is required');
}
else {
	$this->field[$name]['valueclean'] = $this->field[$name]['checkboxvaluealt'];
}
