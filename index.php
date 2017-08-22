<?php				
	$DB_HOST = 'localhost';
	$DB_NAME = 'bjp';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_CHARSET = 'UTF8';
	
	$dsn = "mysql:host=".$DB_HOST.";dbname=".$DB_NAME.";charset=".$DB_CHARSET;
	$db = new PDO($dsn, $DB_USER, $DB_PASS);
	
	
	if (isset($_POST['login']) && isset($_POST['password'])){
		$login_user = $_POST['login'];
		$password_user = md5($_POST['password']);
		
		$data = [":login" => $login_user, ":password" => $password_user];
		$query = "SELECT `users_id` FROM `authorization` WHERE `login` = :login AND `password` = :password AND `status` = 'enabled' LIMIT 1";
		
		$sth = $db->prepare($query);
		$rez = $sth->execute($data);

		$rez = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		if (isset($rez[0]["users_id"])){
			session_start();
			
			$query = "	SELECT t1.`user_f`, SUBSTRING(t1.`user_i`, 1, 1) AS user_i, SUBSTRING(t1.`user_o`, 1, 1) AS user_o, t1.`user_subdivision`, t2.`subdivision_name`, t3.`function_name`, t5.`access_right`
						FROM `users_data` AS t1
						INNER JOIN `hdbk_user_subdivision` AS t2 ON t1.`user_subdivision` = t2.`id`
						INNER JOIN `hdbk_user_function` AS t3 ON t1.`user_function` = t3.`id`
						INNER JOIN `authorization` AS t4 ON t1.`id` = t4.`users_id`
						INNER JOIN `access` AS t5 ON t4.`access` = t5.`id`
						WHERE t1.`id`=:user_id";
			
			$data = [":user_id" => $rez[0]["users_id"]];
			$user_id = $rez[0]["users_id"];
			
			$sth = $db->prepare($query);
			$rez = $sth->execute($data);
			$rez = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$_SESSION["user"] = ["user_id" => $user_id, "user_f" => $rez[0]["user_f"], "user_i" => $rez[0]["user_i"], "user_o" => $rez[0]["user_o"],
								"user_subdivision" => $rez[0]["user_subdivision"], "subdivision_name" => $rez[0]["subdivision_name"], "function_name" => $rez[0]["function_name"],
								"access" => $rez[0]["access"]];
								
			$_SESSION["login"] = $login_user;
			
			header("Location: modules/planning/1/");
		}
		else
			header("Location: index.php");

	}

?>

<html>
    <head>
		<title>ОАО "Брестжилпроект"</title>
		<meta charset="utf-8">
		<link href="assets/css/style_old.css" rel="stylesheet">
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	</head>
    <body>
		<div class="container">
			<div style="font-size: 28px; text-align: center; margin: 10px 0; color: black;">ОАО "Брестжилпроект"</div>
			<p><p>
			<div style="text-align: center; margin-bottom: 20px;">Введите логин и пароль, чтобы войти на сайт</div>
			
			<div class="col-md-offset-3 col-md-6">
				<div class="block-auth">
						<img src="assets/img/logo.png" style="width: 70%; margin: 0px 0px 25px 0px;">
						<form class="form-auth" method="POST" id="auth" action="">
							<div class="form-group">
								<input class="form-control" style="height: 40px;" type="text" name="login" placeholder="Имя пользователя">
							</div>
							<div class="form-group">
								<input class="form-control" style="height: 40px;" type="password" name="password" placeholder="Пароль">
							</div>
							<button class="btn btn-primary" style="width: 100%; height: 40px;">Войти</button>
						</form>
						<div id="auth-result"></div>
				</div>
			</div>
		</div>
	
		<script src="assets/js/jquery-3.1.1.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Проверка на заполнение формы -->
		<script type="text/javascript">
			$('#auth').on("submit", function(e) {
				$('.error').html("");
				if ($(this).find('input[name=login]').val() == '')
				{
					$(this).find('input[name=login]').before('<div class="error">Введите имя</div>');
					return false;
				}
				
				if ($(this).find('input[name=password]').val() == '')
				{
					$(this).find('input[name=password]').before('<div class="error">Введите пароль</div>');
					return false;
				}
					
			});
		</script>
		
	</body>
</html>
</html>