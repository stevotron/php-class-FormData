<?php

// variable parameters can all be found in $p

$html[] = '<input';
$html[] = 'class="form-control"';
if ($p['id'] !== NULL)
	$html[] = 'id="'.htmlspecialchars($p['id']).'"';

if ($p['maxlength'] !== NULL)
	$html[] = 'maxlength="'.htmlspecialchars($p['maxlength']).'"';

$html[] = 'name="'.htmlspecialchars($name).'"';

if ($p['placeholder'] !== NULL)
	$html[] = 'placeholder="'.htmlspecialchars($p['placeholder']).'"';

if ($p['required'] == '1')
	$html[] = 'required="required"';

$html[] = 'type="'.$p['type'].'"';
$html[] = 'value="'.htmlspecialchars($p['value']).'"';

$html[] = '/>';
