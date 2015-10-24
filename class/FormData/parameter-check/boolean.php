<?php

// the array key to locate the value to check is held in $parameter

$check = $this->setting_field[$parameter];

$true  = array(true, '1', 'true', 1);
$false = array(false, '0', 'false', 0);

if (in_array($check, $true, true))
{
	$this->setting_field[$parameter] = '1';
}
else if (in_array($check, $false, true))
{
	$this->setting_field[$parameter] = '0';
}
else
{
	throw new Exception('Invalid value ('.$check.') for for field name ('.$this->setting_field_name.'), parameter ('.$parameter.') - must be boolean');
}
