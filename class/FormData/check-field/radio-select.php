<?php

// $name is field name to check
// $input is submitted data

// params
foreach ($this->field[$name]['option'] as $d)
{
	$options[] = $d[0];
}


// store original input
$this->field[$name]['value'] = $input;


$ignore = array();

if ($this->field[$name]['type'] == 'select')
{
	// possible inputs that will match an array but will not be valid (used for formating dropdown)
	$ignore = array('', '_disabled');// select only
}


if (!in_array($input, $ignore) && in_array($input, $options))
{
	$this->field[$name]['valueclean'] = $input;
}
else if ($this->field[$name]['required'] == '1')
{
	$this->setError($name, 'is required');
}
