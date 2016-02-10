<?php

// variable parameters can all be found in $p

$h1[] = '<select';
$h1[] = ' class="form-control"';

if ($p['id'] !== NULL)
	$h1[] = ' id="'.htmlspecialchars($p['id']).'"';

$h1[] = ' name="'.htmlspecialchars($p['name']).'"';

if ($p['required'] == '1')
	$h1[] = ' required="required"';

$h1[] = '>';

foreach ($p['option'] as $a) {
	$id   = $a[0];
	$desc = $a[1];

	if ($id == '_disabled')
	{
		$opt[] = '<option disabled="disabled">'.htmlspecialchars($desc).'</option>';
	}
	else
	{
		if ($p['value'] != '' && $p['value'] == $id)
		{
			$selected = ' selected="selected"';
			$optionSelected = true;
		}
		else
		{
			$selected = '';
		}
		$opt[] = '<option value="'.htmlspecialchars($id).'"'.$selected.'>'.htmlspecialchars($desc).'</option>';
	}
}
if (!$optionSelected) {
	$placeholder = $p['placeholder'] ? htmlspecialchars($p['placeholder']) : 'Please choose...';
	$h2[] = '<option selected="selected" value="">'.$placeholder.'</option>';
	$h2[] = '<option disabled="disabled"></option>';
}
$h2[] = implode('', $opt);


$html[] = implode('',$h1).implode('',$h2).'</select>';
