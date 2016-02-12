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
			'name'             => 'first-name',
			'required'         => '1',
			'required_message' => 'We\'d love to know your first name!',
			'max_length'       => '50',
		],
		[
			'type'     => 'select',
			'label'    => 'Favourite colour',
			'name'     => 'colour',
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
			'name'               => 'ok',
			'checkbox_value'     => 'yes',
			'checkbox_value_alt' => 'no',
		],
	]);

	// check for form submission
	if ($_POST['submit'] == 'submit') {

		// search POST array for all fields that were set above and check submitted data
		$FormData->checkPost();

/* ********************************* Adding some custom error messages ********************************* */


		// add a generic error that is not linked to any fields, these will always be added to the end of the list
		$FormData->setError(NULL, 'A generic error message');


		// perform further, custom checks on submitted data, for example - create an error if 'first-name' is Paul
		if (!$FormData->hasError('first-name')) {
			$submitted = $FormData->getClean('first-name');
			if (strtolower($submitted) == 'paul') {
				$FormData->setError('first-name', 'Sorry, no-one called Paul is allowed', false);
			}
		}


		// assign an error to a field without generating a message - for example - create an error if the 'colour' is yellow (ID = 2) but the checkbox is not checked
		if ($FormData->getClean('colour') == '2' && $FormData->getClean('ok') == 'no') {
			$FormData->setError('colour');// this field will be highlighted as having an error but no message will be logged, the next line will create the message for both fields
			$FormData->setError('ok', 'If your favourite colour is yellow then you must be OK', false);
		}


/* ***************************************************************************************************** */

		if ($FormData->hasError()) {
			// there was some errors

			// an HTML ready string of errors (separated with '<br />') can be obtained as follows
			$error_message = $FormData->getErrorList(true);

			// just as an example, prepare the data for a confirmation message
			$form_report  = '<div class="alert alert-danger" role="alert"><h4>Form report: Errors!</h4><p>'.$error_message.'</p></div>';
		}
		else {
			// there were no errors so the information can be processed

			$form_report  = '<div class="alert alert-success" role="alert"><h4>Form report: Success!</h4><p>There was no errors</p></div>';
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
<?php if ($form_report) echo $form_report; ?>
	<form action="#" method="post">
		<?= $FormData->returnHtml() ?>
		<hr />
		<button class="btn btn-default" type="submit" name="submit" value="submit">Submit</button>
	</form>
</div>
</body>
</html>
