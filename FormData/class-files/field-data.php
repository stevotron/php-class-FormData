<?php

// all parameter keys must be lowercase and letters or numbers only (required_message / requiredMessage / RequiredMessage all become requiredmessage)
// values determine if parameter is required

// parameter files are only run if parameter is submitted
// name and type are not included as they are required for all fields and checked prior to using these arrays for checking


$this->field_data = [
	'checkbox' => [
		'label'            => true,
		'checkboxvalue'    => false,
		'checkboxvaluealt' => false,
		'id'               => false,
		'required'         => false,
		'requiredmessage'  => false,
		'value'            => false,
	],
	'email' => [
		'label'           => true,
		'id'              => false,
		'maxlength'       => false,
		'minlength'       => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
	],
	'hidden' => [
		'id'              => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
	],
	'number' => [
		'label'           => true,
		'id'              => false,
		'max'             => false,
		'min'             => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'step'            => false,
		'value'           => false,
	],
	'password' => [
		'label'           => true,
		'id'              => false,
		'maxlength'       => false,
		'minlength'       => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
	],
	'radio' => [
		'label'           => true,
		'option'          => true,
		'id'              => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
	],
	'select' => [
		'label'           => true,
		'id'              => false,
		'multiple'        => false,
		'option'          => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
		'min'             => false,
		'max'             => false,
	],
	'text' => [
		'label'           => true,
		'id'              => false,
		'maxlength'       => false,
		'minlength'       => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'value'           => false,
	],
	'textarea' => [
		'label'           => true,
		'id'              => false,
		'maxlength'       => false,
		'maxnl'           => false,
		'minlength'       => false,
		'placeholder'     => false,
		'required'        => false,
		'requiredmessage' => false,
		'rows'            => false,
		'value'           => false,
	],
];
