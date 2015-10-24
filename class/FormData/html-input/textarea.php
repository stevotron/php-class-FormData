<?php

// variable parameters can all be found in $p

$h1[] = '<textarea';
$h1[] = 'class="form-control"';

if ($p['id'] !== NULL)
	$h1[] = 'id="'.htmlspecialchars($p['id']).'"';

if ($p['maxlength'] !== NULL)
	$h1[] = 'maxlength="'.htmlspecialchars($p['maxlength']).'"';

$h1[] = 'name="'.htmlspecialchars($name).'"';

if ($p['placeholder'] !== NULL)
	$h1[] = 'placeholder="'.htmlspecialchars($p['placeholder']).'"';

if ($p['required'] == '1')
	$h1[] = 'required="required"';

if ($p['rows'] !== NULL)
	$h1[] = 'rows="'.htmlspecialchars($p['rows']).'"';

$h1[] = '>';

$html[] = implode(' ', $h1).htmlspecialchars($p['value']).'</textarea>';
