<?php

// variable parameters can all be found in $p

$checkbox_value = isset($p['checkboxvalue']) ? $p['checkboxvalue'] : '1';

$html[] = '<input';

if ($p['value'] == $checkbox_value)
	$html[] = 'checked="checked"';

if ($str = $p['id'])
	$html[] = 'id="'.htmlspecialchars($str).'"';

$html[] = 'name="'.htmlspecialchars($p['name']).'"';

if ($p['required'] == '1')
	$html[] = 'required="required"';

$html[] = 'type="checkbox"';

$html[] = 'value="'.htmlspecialchars($checkbox_value).'"';

$html[] = '/>';
