<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Авторизация</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
</head>
<body>

	<?php
				require "db.php";

				$data = $_POST;
				if ( isset($data['do_login']) )
				{
						$user = R::findOne('users', 'login = ?', array($data['login']));
						if ( $user )
						{
								//логин существует
								if ( password_verify($data['password'], $user->password) )
								{
										//если пароль совпадает, то нужно авторизовать пользователя
										$_SESSION['logged_user'] = $user;
										echo '<div style="color:green;">Вы авторизованы!<br> 
										Можете перейти на <a class="link" href="index.php">главную</a> страницу.</div><hr>';
								}else
								{
										$errors[] = 'Неверно введен пароль!';
								}
				
						}else
						{
								$errors[] = 'Пользователь с таким логином не найден!';
						}
						
						if ( ! empty($errors) )
						{
								//выводим ошибки авторизации
								echo '<div style="color:red;">' .array_shift($errors). '</div><hr>';
						}
				
				}
	?>

	<div id="login">
		<form action="login.php" method="POST">
				
				<span class="fontawesome-user"></span>	
				<input type="text" name="login" placeholder="Введите ваш логин" value="<?php echo @$data['login']; ?>"><br>
				
				<span class="fontawesome-lock"></span>
				<input type="password" name="password" placeholder="Введите ваш пароль" value="<?php echo @$data['password']; ?>"><br>

				<input type="submit" value="Войти" name="do_login">
				
		</form>
	</div>

</body>
</html>