<?php

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// include the class file
include __DIR__.'/../FormData/FormData.php';
$FormData  = new FormData();

try {
	// create the form fields and set parameters
	$FormData->setFields([
		[
			'type'             => 'text',
			'label'            => 'First name',
			'name'             => 'first-name', // 'name' is required for each field, if it is omitted 'id' is used if present
			'id'               => 'first-name',
			'required'         => '1',
			'required_message' => 'We\'d love to know your first name!',
			'max_length'       => '50',
		],
		[
			'type'     => 'number',
			'label'    => 'Favourite multiple of 5',
			'id'       => 'number',
			'required' => '1',
			'min'      => '0',
			'max'      => '100',
			'step'     => '5',
		],
		[
			'type'     => 'select',
			'label'    => 'Favourite colour',
			'id'       => 'colour',
			'required' => '1',
			'option'   => [
				'1' => 'Red',
				'2' => 'Yellow',
				'3' => 'Blue',
			],
		],
		[
			'type'               => 'checkbox',
			'label'              => 'Are you OK?',
			'id'                 => 'ok',
			'checkbox_value'     => 'yes',
			'checkbox_value_alt' => 'no',
		],
	]);

	// check for form submission
	if ($_POST['submit'] == 'submit') {

		// search POST array for all fields that were set above and check submitted data
		$FormData->checkPost();

		if ($FormData->hasError()) {
			// there was some errors - handle them here

			// an object listing all error fields with user friendly messages can be obtained as follows
			$error_obj = $FormData->getErrorList();

			// an HTML ready list of error messages (separated with '<br />') can be obtained as follows
			$error_message = $FormData->getErrorList(true);

			// just as an example, prepare the data for a confirmation message
			$form_report  = '<div class="alert alert-danger" role="alert"><h4>Form report: Errors!</h4><p>'.$error_message.'</p></div>';
		}
		else {
			// there were no errors so the information can be processed

			// example of extracting data from the object
			$first_name = $FormData->getClean('first-name');
			$surname    = $FormData->getClean('surname');
			$colour     = $FormData->getClean('colour');
			$ok         = $FormData->getClean('ok');

			// put the data in a confirmation message
			$form_report  = '<div class="alert alert-success" role="alert">';
			$form_report .= '<h4>Form report: Success!</h4>';
			$form_report .= '<p>';
			$form_report .= 'First name: '.htmlspecialchars($first_name).'<br />';
			$form_report .= 'Surname: '   .htmlspecialchars($surname).'<br />';
			$form_report .= 'Colour ID: ' .htmlspecialchars($colour).'<br />';
			$form_report .= 'OK?: '       .htmlspecialchars($ok);
			$form_report .= '</p>';
			$form_report .= '</div>';
		}
	}
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
	<title>FormData: Complete example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="container">
	<h1>FormData: Complete example</h1>
	<hr />
	<?php if (isset($form_report)) echo $form_report; ?>
	<form action="#" method="post">
		<?= $FormData->returnHtml() ?>
		<hr />
		<button class="btn btn-default" type="submit" name="submit" value="submit">Submit</button>
	</form>
</div>
</body>
</html>
