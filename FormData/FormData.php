<?php

class FormData
{
	private $setting_field      = [];
	private $setting_field_name = '';
	private $setting_field_type = '';
	private $field_error        = [];
	private $generic_error      = [];
	private $field              = [];
	private $field_data         = [];
	
	
	function __construct()
	{
		$this->setFieldData();
	}
	
	
	private function setFieldData()
	{
		require __DIR__.'/class-files/field-data.php';
	}
	
	
	private function checkFieldParameter($parameter, $required)
	{
		// is required parameter set?
		if ($this->setting_field[$parameter] == '' && $required) {
			throw new Exception('Field parameter ('.$parameter.') is required and must be non-empty string for field name ('.$this->setting_field_name.')');
		}
		
		if ($this->setting_field[$parameter] != '') {
			// check parameter
			switch ($parameter) {
				case 'multiple':
				case 'required':
					$file = 'boolean';
					break;

				case 'option':
				case 'step':
					$file = $parameter;
					break;

				case 'checkboxvalue':
				case 'checkboxvaluealt':
				case 'id':
				case 'label':
				case 'max':
				case 'maxlength':
				case 'maxnl':
				case 'min':
				case 'minlength':
				case 'placeholder':
				case 'requiredmessage':
				case 'rows':
				case 'value':
					$file = NULL;
//					$file = $parameter;
					break;
				
				default:
					throw new Exception('Unexpected parameter ('.$parameter.') submitted');
			}
			
			if ($file) {
				// file will use the variable $parameter to check
				require __DIR__.'/class-files/parameter-check/'.$file.'.php';
				// file will update $this->setting_field[$parameter] if needed
			}
			
			// set parameter
			$this->field[$this->setting_field_name][$parameter] = $this->setting_field[$parameter];
		}
	}
	
	
	private function cleanString($string)
	{
		$search = array('_','-',' ');
		$string = str_replace($search, '', $string);
		$string = strtolower($string);
		
		return $string;
	}


	private function makeObject($input)
	{
		if (is_array($input)) {
			$obj = new stdClass();
			foreach ($input as $key => $val) {
				if (is_array($val)) {
					$val = $this->makeObject($val);
				}
				$obj->$key = $val;
			}
			return $obj;
		}
		return $input;
	}


	private function setFieldParameterName()
	{
		$name = $this->setting_field['name'];
		
		if ($name === NULL) {
			// use id if name is not set
			$name = $this->setting_field['id'];
		}
		
		if ($name == '') {
			throw new Exception('Field parameter (name) is required and must be a non empty string (parameter (id) is also checked if name is not set)');
		}
		
		if (array_key_exists($name, $this->field)) {
			throw new Exception('Trying to set field name ('.$name.') multiple times');
		}
		
		$this->setting_field_name = $name;
	}
	
	
	private function setFieldParameterType()
	{
		$type = $this->setting_field['type'];
		
		if ($type == '') {
			throw new Exception('Field parameter (type) is required and must be a non empty string');
		}
		
		if (!array_key_exists($type, $this->field_data)) {
			throw new Exception('Invalid field type ('.$type.') submitted');
		}
		
		$this->setting_field_type = $type;
	}
	
	
	private function setSettingField($array)
	{
		foreach ($array as $k => $v) {
			$k = $this->cleanString($k);
			$this->setting_field[$k] = $v;
		}
	}
	
	
	// SETTING FIELDS
	
	
	public function setFields($fields_array)
	{
		foreach ($fields_array as $field_details) {
			$this->setField($field_details);
		}

		return true;
	}
	
	
	public function setField($field_details_array)
	{
		$this->setSettingField($field_details_array);

		// check the field name is valid (id will be used if name is not set)
		$this->setFieldParameterName();
		unset($this->setting_field['name']);

		// check the field type is valid
		$this->setFieldParameterType();
		$this->field[$this->setting_field_name]['type'] = $this->setting_field_type;
		unset($this->setting_field['type']);
		
		// iterate through remaining field type parameters
		foreach ($this->field_data[$this->setting_field_type] as $parameter => $required) {
			$this->checkFieldParameter($parameter, $required);
			unset($this->setting_field[$parameter]);
		}
		
		// any left over parameters?
		if (count($this->setting_field) > 0) {
			foreach ($this->setting_field as $k => $v) {
				$list[] = $k;
			}
			throw new Exception ('Invalid parameters ('.implode(', ', $list).') submitted for field name ('.$this->setting_field_name.')');
		}
		
		return true;
	}
	
	
	public function setValue($name, $value)
	{
		if (!isset($this->field[$name])) {
			throw new Exception (__METHOD__.' - Cannot set value for field ('.$name.'), does not exist');
		}
		
		$this->field[$name]['value'] = (string) $value;
		
		return true;
	}

	
	// GETTING HTML ELEMENTS
	
	
	public function returnHtmlInput($name)
	{
		if ($this->field[$name]) {
			switch ($this->field[$name]['type']) {
				case 'checkbox':
				case 'hidden':
				case 'number':
				case 'select':
				case 'radio':
					$file = $this->field[$name]['type'];
					break;
				
				case 'email':
				case 'password':
				case 'text':
					$file = 'email-password-text';
					break;
				
				case 'textarea':
					$file = 'textarea';
					break;
				
				default:
					$file = NULL;
			}
			
			if ($file) {
				// put field parameters into a handy array...
				$p = $this->field[$name];
				$p['name'] = $name;
				
				require __DIR__.'/class-files/html-input/'.$file.'.php';
			}
			else {
				$html[] = '<strong style="color:red">Cannot process field type ('.htmlspecialchars($this->field[$name]['type']).')</strong>';
			}
			
			return implode(' ', $html);
		}
		else {
			return '<strong style="color:red">Invalid field name ('.htmlspecialchars($name).')</strong>';
		}
	}
	
	
	public function returnHtmlLabel($name)
	{
		if ($this->field[$name]) {
			$html[] = '<label class="control-label"';
			if ($this->field[$name]['id'])
				$html[] = ' for="'.htmlspecialchars($this->field[$name]['id']).'"';
			$html[] = ' >'.htmlspecialchars($this->field[$name]['label']).'</label>';
			return implode('', $html);
		}
		
		return '<strong style="color:red">(LBL:'.htmlspecialchars($name).')</strong> ';
	}
	
	
	public function returnHtmlGroup($name)
	{
		$error = $this->hasError($name) ? ' has-error' : ''; 
		
		switch ($this->field[$name]['type']) {
			case 'checkbox':
				$html[] = '<div class="checkbox'.$error.'">';
				$html[] = '<label>';
				$html[] = $this->returnHtmlInput($name);
				$html[] = ' '.htmlspecialchars($this->field[$name]['label']);
				$html[] = '</label>';
				$html[] = '</div>';
				break;
		
			case 'email':
			case 'number':
			case 'password':
			case 'radio':
			case 'select':
			case 'text':
			case 'textarea':
				$html[] = '<div class="form-group'.$error.'">';
				$html[] = $this->returnHtmlLabel($name);
				$html[] = $this->returnHtmlInput($name);
				$html[] = '</div>';
				break;
			
			case 'hidden':
				$html[] = $this->returnHtmlInput($name);
				break;
			
			default:
				$html[] = '<div class="form-group">';
				$html[] = '<strong style="color:red">(GRP:'.htmlspecialchars($name).')</strong>';
				$html[] = '</div>';
		}
		return implode('', $html);
	}

	
	public function returnHtml()
	{
		foreach ($this->field as $name => $d) {
			$html[] = $this->returnHtmlGroup($name);
		}
		return implode('', $html);
	}
	
	
	// RETRIEVING SAVED DATA



	public function getClean($name)
	{
		return $this->getField($name, 'value_clean');
	}

	public function getOption($name, $option_id)
	{
		return $this->getField($name, 'option', $option_id);
	}

	public function getField($name = NULL, $param = NULL, $option_id = NULL)
	{
		// return entire data set
		if ($name === NULL) {
			if (count($this->field) > 0) {
				return $this->makeObject($this->field);
			}
			return NULL;
		}

		// does the field name exist?
		if (!isset($this->field[$name])) {
			return NULL;
		}

		// return specific field data
		if ($param === NULL) {
			return $this->makeObject($this->field[$name]);
		}
		
		// does parameter name exist?
		$param = $this->cleanString($param);

		if (!isset($this->field[$name][$param])) {
			return NULL;
		}

		// return parameter data
		if ($option_id === NULL) {
			return $this->makeObject($this->field[$name][$param]);
		}

		// return a select or radio value by ID
		if ($param != 'option') {
			throw new Exception ('Option ID submitted when parameter value is not option');
		}

		foreach ($this->field[$name]['option'] as $option_array) {
			if ($option_array[0] == $option_id) {
				return $option_array[1];
			}
		}

		return NULL;
	}


	// CHECK DATA
	
	
	public function checkPost()
	{
		foreach ($this->field as $name => $a) {
			$this->checkField($name, $_POST[$name]);
		}
		
		return $this->hasError() ? false : true;
	}
	
	
	public function checkGet()
	{
		foreach ($this->field as $name => $a) {
			$this->checkField($name, $_GET[$name]);
		}
		
		return $this->hasError() ? false : true;
	}
	
	
	public function checkField($name, $input)
	{
		if (!isset($this->field[$name])) {
			throw new Exception(__METHOD__.' - Trying to check a field ('.$name.') that has not been created');
		}
		
		switch ($this->field[$name]['type']) {
			case 'checkbox':
			case 'hidden':
			case 'number':
				$file = $this->field[$name]['type'];
				break;
			
			case 'email':
			case 'password':
			case 'text':
			case 'textarea':
				$file = 'email-password-text-textarea';
				break;
			
			case 'radio':
			case 'select':
				$file = 'radio-select';
				break;
			
			default:
				throw new Exception(__METHOD__.' - Unexpected field type ('.$this->field[$name]['type'].') in check');
		}
		
		require __DIR__.'/class-files/check-field/'.$file.'.php';
		
		return $this->hasError($name);
	}
	
	
	// ERROR MANAGEMENT


	public function setError($name, $message = true, $prepend_message = true)
	{
		if ($name === NULL) {
			// add an error not linked to a specific field
			if (!is_string($message)) {

				throw new Exception ('Message must be a string when file name is NULL');
			}
			$this->generic_error[] = $message;
		}
		else if (!isset($this->field[$name])) {

			throw new Exception ('Cannot set error for field ('.$name.'), does not exist');
		}
		else if ($message === true) {

			// mark a field as having an error but do not record a message
			$this->field[$name]['has_error'] = true;
		}
		else if (!is_string($message)) {

			throw new Exception ('Message must be boolean true or a string');
		}
		else {

			$this->field[$name]['has_error'] = true;

			if ($message == 'is required' && $this->field[$name]['requiredmessage']) {

				$this->field_error[$name] = $this->field[$name]['requiredmessage'];
			}
			else if ($prepend_message) {

				$this->field_error[$name] = $this->field[$name]['label'] . ' ' . $message;
			}
			else {

				$this->field_error[$name] = $message;
			}
		}

		return true;
	}


	public function hasError($name = NULL)
	{
		if ($name === NULL) {

			$found_error = false;
			foreach ($this->field as $data) {
				if ($data['has_error']) {
					$found_error = true;
					break;
				}
			}

			if (count($this->field_error) > 0 || count($this->generic_error) > 0 || $found_error) {
				return true;
			}
			else {
				return false;
			}
		}

		if (!isset($this->field[$name])) {
			throw new Exception (__METHOD__.' - Cannot check field ('.$name.'), does not exist');
		}

		if ($this->field_error[$name] !== NULL) {
			return $this->field_error[$name];
		}

		if ($this->field[$name]['has_error']) {
			return true;
		}

		return false;
	}


	public function getErrorList($html_ready = false)
	{
		if ($this->hasError()) {

			$error_array = [];

			// extract errors this way to ensure error list order matches field order - errors can be custom added after automatic check
			foreach ($this->field as $name => $data) {
				if (isset($this->field_error[$name])) {
					$error_array[] = $this->field_error[$name];
				}
			}

			// add any generic errors
			$error_array = array_merge($error_array, $this->generic_error);

			if (count($error_array) == 0) {
				$error_array[] = 'Errors have been found but no messages have been generated';
			}

			if (!$html_ready) {
				return $this->makeObject($error_array);
			}

			foreach ($error_array as $v) {
				$a[] = htmlspecialchars($v);
			}
			return implode('<br />',$a);
		}

		return false;
	}
}
