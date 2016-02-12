<?php

/*
 * Two ways to declare select options.
 *
 * Do not mix the two methods as unexpected results can occur.
 */


// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// include the class file
include __DIR__.'/../FormData/FormData.php';
$FormData  = new FormData();

try {
	// create the select form field
	$FormData->setFields([
		[
			'type'     => 'select',
			'label'    => 'Options declared as pairs',
			'id'       => 'pairs',
			// options can be declared as a $key => $value pair in the array...
			'option'   => [
				'1' => 'Blue',
				'2' => 'Red',
				'3' => 'Yellow',
				'4' => 'Green',
				'5' => 'Orange',
			],
		],
		[
			'type'     => 'select',
			'label'    => 'Options declared as sub arrays',
			'id'       => 'arrays',
			'required' => '1',
			// ... or as a sub array with two elements
			'option'   => [
				['1', 'Blue'],
				['2', 'Red'],
				['_disabled', 'Brown'],// a disabled option can be added using the special key name '_disabled'...
				['3', 'Green'],
				['4', 'Orange'],
				['_disabled', ''],// '_disabled' is also useful for spacing options...
				['10', 'Earth'],
				['11', 'Wind'],
				['12', 'Fire'],
			],
		],
	]);
}
catch (Exception $e) {
	echo 'Exception caught: '.$e->getMessage();
	exit;
}

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FormData: Select options</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="container">
	<h1>FormData: Select options</h1>
	<hr />
<?php if ($form_report) echo $form_report; ?>
	<form>
		<?= $FormData->returnHtml() ?>
	</form>
</div>
</body>
</html>
