<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

require_once('db.php');

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>CrytpoScam</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-GQGU0fMMi238uA+a/bdWJfpUGKUkBdgfFdgBm72SUQ6BeyWjoY/ton0tEjH+OSH9iP4Dfh+7HM0I9f5eR0L/4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1><a href="index.php"><i class="fas fa-home"></i>CrytpoScam</a></h1>
				<a href="buy.php"><i class="fab fa-bitcoin"></i></i>Comprar</a>
				<a href="withdraw.php"><i class="far fa-money-bill-alt"></i>Retirar</a>				<a href="deposit.php"><i class="fas fa-money-bill-alt"></i>Deposito</a>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Perfil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Terminar Sessão</a>
			</div>
		</nav>
		<div class="content">
		<h2>Pagina Perfil</h2>
	
		<p class="card-text bg-dark text-white">Editar Nome de Utilizador</p>
			<?php
				if(!empty($_SESSION['success']))
				{
					echo '<div class="alert alert-success" role="alert">'. $_SESSION['success'] . '</div>';
					unset($_SESSION['success']);
				}
				else if(!empty($_SESSION['error']))
				{
					echo '<div class="alert alert-danger" role="alert">'. $_SESSION['error'] . '</div>';
					unset($_SESSION['error']);
				}
			?>
			<div class="card-text bg-dark text-white">
				<form action="change.php" method="post">
					<label for="password">
						<h6>Password Antigo:</h6>
					</label>
					<!-- <br> -->
                	<input type="password" name="password" placeholder="Password Antiga" id="password" required class="form-label">
					<br>
					<label for="username">
						<h6>Password Novo:</h6>
					</label>
					<!-- <br> -->
                    <input type="password" name="newpassword" placeholder="Password novo" id="newpassword" required class="form-label">
					<input type="hidden" id="changetype" name="changetype" value="password">
					<br>
					<button type="submit" class="btn btn-primary">Trocar Password</button>
                </form>
			</div>
		</div>
	</body>
</html>