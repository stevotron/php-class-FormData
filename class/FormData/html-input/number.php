<?php

// variable parameters can all be found in $p

$html[] = '<input';
$html[] = 'class="form-control"';

if ($p['id'])
	$html[] = 'id="'.htmlspecialchars($p['id']).'"';

if ($p['min'])
	$html[] = 'min="'.htmlspecialchars($p['min']).'"';

if ($p['max'])
	$html[] = 'max="'.htmlspecialchars($p['max']).'"';

$html[] = 'name="'.htmlspecialchars($p['name']).'"';

if ($p['placeholder'])
	$html[] = 'placeholder="'.htmlspecialchars($p['placeholder']).'"';

if ($p['required'] == '1')
	$html[] = 'required="required"';

if ($p['step'])
	$html[] = 'step="'.htmlspecialchars($p['step']).'"';

$html[] = 'type="number"';
$html[] = 'value="'.htmlspecialchars($p['value']).'"';
$html[] = '/>';
