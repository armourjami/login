<?php

class Session {
	public static function put($name, $value){
		return $_SESSION[$name] = $value;
	}	
	
	public static function get($token_name){
		return $_SESSION[$token_name];
	}

	public static function exists($token_name){
		if(isset($_SESSION[$token_name])){
			return true;
		}
		return false;
		//could also be written return isset($_Session[$name]) ? true : false;
	}

	public static function delete($token_name){
		if(self::exists($token_name)){
			unset($_SESSION[$token_name]);
		}
	}

	public static function flash($name, $string = ''){
		if(self::exists($name)){
			$session = self::get($name);
			self::delete($name);
			return $session;
		}else{
			self::put($name, $string);
		}	
		return '';
	}
}

?>
