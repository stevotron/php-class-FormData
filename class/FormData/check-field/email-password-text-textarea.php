<?php

// $name is field name to check
// $input is submitted data

// params
$required   = $this->field[$name]['required'];
$max_length = $this->field[$name]['maxlength'];
$min_length = $this->field[$name]['minlength'];
$max_nl     = floor($this->field[$name]['maxnl']);
$type       = $this->field[$name]['type'];


$input = trim($input);


if ($type == 'password')
{
	$this->field[$name]['value'] = '';
	$this->field[$name]['valueclean'] = $input;
}
else
{
	// store original input
	$this->field[$name]['value'] = $input;
	
	if ($max_nl == '0')
	{
		// replace any white space groups with a single space
		$input = preg_replace("|\s+|"," ",$input);
		
		$this->field[$name]['value_clean'] = $input;
		
		$nl_count = 0;
	}
	else
	{
		// convert all new lines to \n
		$search = array ("\r","\r\n"); 
		$input = str_replace($search, "\n", $input);
		
		// create string of maximum number of new lines
		$nl_string = '';
		for ($i=0; $i<$max_nl; $i++)
		{
			$nl_string .= "\n";
		}
		
		$input = preg_replace("/\n[\v\f\t ]+/", "\n", $input);// remove any white space after a new line, that is not a line break
		$input = preg_replace("/[\v\f\t ]+/", " ", $input);// any white space group, that does not include a line break, is reduced to a single space
		$input = preg_replace("/(\n){".$max_nl.",}/", $nl_string, $input);// limit consecutive new lines to specified amount
		
		$this->field[$name]['value_clean'] = $input;
		
		$nl_count = substr_count($input, "\n");
	}
}

// number of characters in cleaned submitted string
$char_count = strlen($input) - $nl_count;

if ($required == '1' && $char_count == 0)
{
	$this->setError($name, 'is required');
}
else if ($char_count < $min_length || ($max_length != '' && $char_count > $max_length))
{
	if ($min_length == $max_length)
	{
		$this->setError($name, 'must be '.$min_length.' characters long');
	}
	else if ($min_length == '')
	{
		$this->setError($name, 'must be less than '.$max_length.' characters long');
	}
	else if ($max_length == '')
	{
		$this->setError($name, 'must be more than '.$min_length.' characters long');
	}
	else
	{
		$this->setError($name, 'must be '.$min_length.' - '.$max_length.' characters long');
	}
}
else if ($type == 'email' && !filter_var($input, FILTER_VALIDATE_EMAIL) && $char_count != 0)
{
	$this->setError($name, 'was not recognised as a valid email address');
}
