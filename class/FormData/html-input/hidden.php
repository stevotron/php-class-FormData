<?php

// variable parameters can all be found in $p

$html[] = '<input';

if ($p['id'] !== NULL)
	$html[] = 'id="'.htmlspecialchars($p['id']).'"';

$html[] = 'name="'.htmlspecialchars($p['name']).'"';
$html[] = 'type="hidden"';
$html[] = 'value="'.htmlspecialchars($p['value']).'"';

$html[] = '/>';
