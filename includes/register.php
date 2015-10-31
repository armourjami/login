<?php
require_once '../core/init.php';

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validation();	
		$validate->check($_POST, array(
		'username' => array(
			'min' => 2,
			'max' => 20,
			'required' => true,
			'unique' => true
		),
		'password' => array(
			'min' => 6,
			'required' => true	
		),
		'password_again' => array(
			'min' => 6,
			'matches' => 'password',
			'required' => true
		),
		'name' => array(	
			'required' => true,
			'min' => 2,
			'max' => 50
		),
		));
		if($validate->passed()){

			$user = new User();
			$salt = Hash::salt(32);
			try{
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));
				echo Session::flash('success', 'You have been registered');	
				Redirect::to('index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}

		}else{
			foreach($validate->errors() as $error){
				echo $error, '<br>';
			}
		}
	}


}
?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>">
	</div>
	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="password_again">Please re-enter your password</label>
		<input type="password" name="password_again" id="password_again">
	</div>
	<div class="field">
		<label for="name">Enter your name</label> 
		<input type="text" name="name" id="name" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">
</form>
