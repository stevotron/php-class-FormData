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
		'type'       => 'text',
		'label'      => 'First name',
		'id'         => 'first-name',
		'required'   => '1',
		'max_length' => '50',
	],
	[
		'type'     => 'number',
		'label'    => 'Age',
		'id'       => 'age',
		'required' => '1',
		'min'      => '1',
		'max'      => '100',
		'step'     => '1',
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
		]
	]
]);	
```

### Output an HTML form (bootstrap required)

```html
<form action="#" method="post">
	<?= $FormData->returnHtml() ?>
	<button class="btn btn-default" type="submit" name="submit" value="submit">Submit</button>
</form>
```

### Check submitted data

```php
if ($_POST['submit'] == 'submit') {
	$FormData->checkPost();
	if ($FormData->hasError()) {
		$html_encoded_error_message = $FormData->getErrorList(true);
	}
	else {
		$first_name = $FormData->getClean('first-name');
		$age        = $FormData->getClean('age');
		$colour_id  = $FormData->getClean('colour');
	}
}
```
