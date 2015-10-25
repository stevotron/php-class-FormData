<?php

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// include the class file
include __DIR__.'/../class/FormData.php';
$FormData  = new FormData();

try {
	// create the form fields and set parameters
	$FormData->setFields([
		[
			// name is a required parameter, if omitted 'id' will be used
			// this field's name will be set as 'first-name'
			'type'             => 'text',
			'label'            => 'First name',
			'id'               => 'first-name',
			'required'         => '1',
			'required_message' => 'We\'d love to know your first name!',
			'max_length'       => '50',
		],
		[
			'type'       => 'text',
			'label'      => 'Surname',
			'id'         => 'surname',
			'required'   => '1',
			'max_length' => '50',
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
		// search POST array for all fields that were set above and validate
		if ($FormData->checkPost()) {
			// if true, there were no errors so the information can be processed

			// example of extracting data from the object
			$data['first-name'] = $FormData->getField('first-name', 'value_clean');
			$data['surname']    = $FormData->getField('surname', 'value_clean');
			$data['colour']     = $FormData->getField('colour', 'value_clean');
			$data['ok']         = $FormData->getField('ok', 'value_clean');

			// just as an example, prepare the data for a confirmation message
			$form_report  = '<div class="alert alert-success" role="alert"><h4>Form report: Success!</h4><p>First name: '.htmlspecialchars($data['first-name']).'<br />Surname: ';
			$form_report .= htmlspecialchars($data['surname']).'<br />Colour ID: '.htmlspecialchars($data['colour']).'<br />OK?: '.htmlspecialchars($data['ok']).'</p></div>';
		}
		else {
			// if false, there was some errors - handle them here

			// an object listing all error fields with user friendly messages can be obtained as follows
			$error_obj = $FormData->getErrorList();

			// an HTML ready string of errors (separated with '<br />') can be obtained as follows
			$error_message = $FormData->getErrorList(true);

			// just as an example, prepare the data for a confirmation message
			$form_report  = '<div class="alert alert-danger" role="alert"><h4>Form report: Errors!</h4><p>'.$error_message.'</p></div>';
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
