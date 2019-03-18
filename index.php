<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Форма входа/регистрации нового пользователя</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
</head>
<body>
	<?php
		require "db.php";
	?>

	<div class="box-users">
		<div class="box-users__wrapper">
			<?php if( isset($_SESSION['logged_user']) ) : ?>
				<span>Авторизован!</span>
				Привет, <?php echo $_SESSION['logged_user']->login; ?>
				<a href="logout.php">Выйти</a>
			<?php else : ?>
				<span>Вы не авторизованы!</span>
				<a href="login.php">Авторизация</a>
				<a href="signup.php">Регистрация</a>
			<?php endif;  ?>
		</div>
	</div>

</body>
</html>
