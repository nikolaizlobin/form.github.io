<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Регистрация</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
</head>
<body>
	<?php
			require "db.php";
			$data = $_POST;
 
			function captcha_show(){
					$questions = array(
							1 => '2 + 3',
							2 => '15 + 14',
							3 => '45 - 10',
							4 => '33 - 3'
					);
					$num = mt_rand( 1, count($questions) );
					$_SESSION['captcha'] = $num;
					echo $questions[$num];
			}
			 
			
			if ( isset($data['do_signup']) )
			{
				
			// проверка формы на пустоту полей а так же недопустимые символы логина
					$errors = array();
					if ( trim($data['login']) == '' )
					{
							$errors[] = 'Введите логин';
					}
					
					if ( trim($data['login']) == (preg_match("#^[aA-zZ0-9\-_]+$#", $data['login'])) )
					{
							$errors[] = 'Введены недопустимые символы в поле логина';
					}
			 
					if ( trim($data['email']) == '' )
					{
							$errors[] = 'Введите Email';
					}
			 
					if ( $data['password'] == '' )
					{
							$errors[] = 'Введите пароль';
					}
			 
					if ( $data['password_2'] != $data['password'] )
					{
							$errors[] = 'Повторный пароль введен не верно!';
					}
			 
					//проверка на существование одинакового логина
					if ( R::count('users', "login = ?", array($data['login'])) > 0)
					{
							$errors[] = 'Пользователь с таким логином уже существует!';
					}
			 
					//проверка на существование одинакового email
					if ( R::count('users', "email = ?", array($data['email'])) > 0)
					{
							$errors[] = 'Пользователь с таким Email уже существует!';
					}
			 
					//проверка капчи
					$answers = array(
							1 => '5',
							2 => '29',
							3 => '35',
							4 => '30'
					);
					if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
					{
							$errors[] = 'Ответ на вопрос указан не верно!';
					}
			 
			 
					if ( empty($errors) )
					{
							//ошибок нет, теперь регистрируем
							$user = R::dispense('users');
							$user->login = $data['login'];
							$user->email = $data['email'];
							$user->password = password_hash($data['password'], PASSWORD_DEFAULT); 
							
							R::store($user);
							echo '<div style="color:green;">Вы успешно зарегистрированы! Можете перейти на <a class="link" href="index.php">главную</a> страницу.</div><hr>';
					}else
					{
							echo '<div style="color:red;">' .array_shift($errors). '</div><hr>';
					}
			 
			}
	?>

	<div id="login">
		<form  name="form" action="signup.php" method="POST">

			<span class="fontawesome-user"></span>	
			<input type="text" name="login" placeholder="Введите логин" value="<?php echo @$data['login']; ?>">

			<span class="fontawesome-envelope-alt"></span>	
			<input type="email" name="email" placeholder="Введите email" value="<?php echo @$data['email']; ?>">
			
			<span class="fontawesome-lock"></span>
			<input type="password" placeholder="Введите пароль" name="password">

			<span class="fontawesome-lock"></span>
			<input type="password" placeholder="Введите пароль еще раз" name="password_2">
			
			<strong><?php captcha_show(); ?></strong>
			<input type="text" placeholder="Введите правильный ответ" name="captcha"><br>

			<input type="submit" value="Зарегестрироваться" name="do_signup">
			
		</form>
	</div>

</body>
</html>
