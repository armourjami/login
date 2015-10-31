<?php

class Validation {
		
		private $_db = null,
			$_errors = array(),
			$_passed = false;

		public function __construct(){
			$this->_db = DB::getInstance();	
		}

		public function check($source, $fields){
			foreach($fields as $field => $rules){
				foreach($rules as $rule => $value){
					$name = $source[$field];
					if($rule === 'required' && empty($name)){
						array_push($this->_errors, "{$field} field is not set");
					}else if(!empty($name)){
						switch($rule){
							case 'min': 
									if(strlen($name)< $value){
										array_push($this->_errors, "{$field} is below minimum value");
									}
							break;
							case 'max': 
									if(strlen($name)> $value){
										array_push($this->_errors, "{$field} is above maximum value");
									}
							break;
							case 'unique':	
									if($value && $this->_db->get('users', array($field, '=', $name))->count()){
										array_push($this->_errors, "{$field} has a duplicate value and did not pass");
									}			
							break;
							case 'matches':
									if($name != $source[$value]){
										array_push($this->_errors, "Passwords do not match");
									}
							break;
						}
				}
			}
		}	
		if(empty($this->_errors)){
			$this->_passed = true;
			if($this->passed()){
				return $this;
			}
		}else{
			$this->errors();
		}	
		return $this;
	}
	
	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}
?>
