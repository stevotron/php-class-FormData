# php-class-FormData

* Create fields, setting field type and various parameters
* Validate submitted data (POST, GET or individual fields) against created fields
* Perform custom checks on fields and set bespoke error messages
* Retrieve error messages for individual fields or complete form
* Output HTML inputs, labels, field groups or entire forms, with bootstrap class included

More examples and docs in the [Wiki](https://github.com/prcd/php-class-FormData/wiki).

### Create some fields

```php
$FormData->setFields([
	[
		'type'             => 'text',
		'label'            => 'First name',
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
```

### Output an HTML form (bootstrap required)

```html
<form action="#" method="post">
	<?= $FormData->returnHtml() ?>
	<button class="btn btn-default" type="submit" name="submit" value="submit">Submit</button>
</form>
```

### Check submitted data and get cleaned values

```php
if ($_POST['submit'] == 'submit') {
	$FormData->checkPost();
	if ($FormData->hasError()) {
		$html_encoded_error_message = $FormData->getErrorList(true);
	}
	else {
		$first_name = $FormData->getClean('first-name');
		$number     = $FormData->getClean('number');
		$colour_id  = $FormData->getClean('colour');
		$ok         = $FormData->getClean('ok');
	}
}
```

### Lots more functionality

Check out the [Wiki](https://github.com/prcd/php-class-FormData/wiki) for more examples and docs.
