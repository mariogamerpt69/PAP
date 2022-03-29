<?php
session_start();

$error = "";

if(isset($_SESSION['loggedin'])) {
	header('location: /');
	exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST['username'], $_POST['password'])) {
		$error = "Insira todos os dados";
	} else {
		require_once('config.php');

		if($stmt = $con->prepare('SELECT id, password, perm FROM users where username = ?')) {
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0) {
				$stmt->bind_result($id, $password_hash, $perm);
				$stmt->fetch();
				if(password_verify($_POST['password'], $password_hash)) {
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['id'] = $id;
					$_SESSION['perm'] = $perm;
					header('location: /');
				} else {
					$error = "A palavra-Passe está incorreta";
				}
			} else {
				$error = "O Nome de Utilizador inserido não existe";
			}
			$stmt->close();
		} else {
			$error = "Erro de SQL, Contacte o Administrador!!";
		}
	}
}
?>

<!doctype html>
<html lang="pt-PT">
  <head>
  	<title>School Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<img src="/images/logo.png" alt="AGEVC">
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
				<?php
					if(!empty($error)) {
						echo '<div class="alert alert-danger" role="alert"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' . $error . '</div>';
					}
            	?>
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4">Insere os dados de login</h3>
						<form action="/login.php" method="post" class="login-form">
		      		<div class="form-group">
		      			<input type="text" class="form-control rounded-left" name="username" id="username" placeholder="Username" required>
		      		</div>
	            <div class="form-group d-flex">
	              <input type="password" class="form-control rounded-left" name="password" id="password" placeholder="Password" required>
	            </div>
	            <div class="form-group d-md-flex">
					<div class="w-50 text-md-right">
						<a href="#">Recuperar Palavra-Passe</a>
					</div>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Iniciar Sessão</button>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  	<script src="js/popper.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>
	</body>
</html>

