<?php

// variable parameters can all be found in $p

foreach ($p['option'] as $a)
{
	$value       = $a[0];
	$description = $a[1];
	
	unset ($h1, $h2, $h3);
	
	$h1[] = '<div class="radio">';
	$h1[] = '<label>';
	
	$h2[] = '<input';
	if ($p['value'] == $value)
		$h2[] = 'checked="checked"';
	if ($p['id'] !== NULL)
		$h2[] = 'id="'.htmlspecialchars($p['id']).'-'.htmlspecialchars($p['name']).'"';
	$h2[] = 'name="'.htmlspecialchars($p['name']).'"';
	$h2[] = 'type="radio"';
	$h2[] = 'value="'.htmlspecialchars($value).'"';
	$h2[] = '/>';
	$h2[] = htmlspecialchars($description);
	
	$h3[] = '</label>';
	$h3[] = '</div>';
	
	$h[] = implode('', $h1).implode(' ', $h2).implode('', $h3);
}

$html[] = implode('', $h);
