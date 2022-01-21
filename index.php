<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
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
			<h2>Bem vindo de volta, <?=$_SESSION['name']?>!</h2>
			<p class="card-text bg-dark text-white">Resumo Dos Seus Saldos</p>
			<?php 
			require_once('db.php');
			require_once('functions/f2s.php');

			$totval = 0;

			if($stmt2 = $con->prepare('SELECT usd FROM accounts WHERE id = ?')) {
				$stmt2->bind_param('i', $_SESSION['id']);
				$stmt2->execute();
				$stmt2->bind_result($usd);
				$stmt2->fetch();
				$stmt2->close();


				if($usd > 0) {
					echo('<p class="card-text bg-dark text-white">Fiat</p>');
					$totval += $usd;
					$sheesh = number_format((float)$usd, 2, '.', '');
					// echo('<div class="card-group bg-dark text-white">');
					echo('<div class="card bg-dark text-white">');
					echo '<div class="card-body">';
					echo '<h5 class="card-title">Dolar</h5>';
					echo '<h6 class="card-subtitle mb-2 text-muted">USD</h6>';
					echo '<p class="card-text">' . f2s($sheesh) . ' <i class="fas fa-dollar-sign"></i></p>';
					// echo('<a href="#" class="card-link">Trocar</a>');
					if($sheesh <= 10) {
						echo('<p class="card-text bg-dark text-white">O seu saldo é baixo! <a href="#" class="card-link">Faça um deposito</a></p>');
					}
					echo '</div>';
					echo '</div>';


					// echo '<div class="card bg-dark text-white">';					
					// echo '<div class="card-body">';
					// echo '<h5 class="card-title">' . 'Total' . '</h5>';
					// echo '<h6 class="card-subtitle mb-2 text-muted">USD</h6>';
					// echo '<p class="card-text">' . f2s($totval) . ' <i class="fas fa-dollar-sign"></i></p>';
					// echo '</div>';
					// echo '</div>';
				}

			}

			if ($stmt = $con->prepare('SELECT cryptos.name, cryptos.shortname, cryptos.img, useracc.value FROM cryptos INNER JOIN useracc ON useracc.cryptoid = cryptos.id WHERE useracc.userid = ? ORDER BY cryptos.shortname ASC')) {
				// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
				$stmt->bind_param('s', $_SESSION['id']);
				$stmt->execute();
				// $stmt->store_result();
				$meta = $stmt->result_metadata(); 
				while ($field = $meta->fetch_field()) 
				{ 
					$params[] = &$row[$field->name]; 
				}

				call_user_func_array(array($stmt, 'bind_result'), $params);
				$a = false;
				while ($stmt->fetch()) { 
					foreach($row as $key => $val) 
					{ 
						$a = true;
						$c[$key] = $val; 
					} 
					$result[] = $c; 
				} 
				$stmt->close();

				if ($a) {
					// echo('<p class="card-text bg-dark text-white">Spot</p>');
					// echo('<div class="card-group bg-dark text-white">');
					// echo('<div class="">Fiat</div>');
					$first = true;
					$last = false;

					foreach($result as $res)
					{
						if($res['value'] != 0)
						{
							if($first)
							{
								echo('<p class="card-text bg-dark text-white">Spot</p>');
								echo('<div class="card-group bg-dark text-white">');
								$first = false;
								$last = true;
							}
							$val = 0;
							if($res['shortname'] != 'USDT')
							{
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, "https://api.binance.com/api/v3/ticker/price?symbol=".$res['shortname']."USDT");
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$output = curl_exec($ch);
								curl_close($ch);
								$output = json_decode($output, true);
								$price = $output['price'];
								$val = $price * $res['value'];
							}
							else
							{
								$val = $res['value'];
							}
							$totval += $val;
							echo '<div class="card bg-dark text-white">';
							echo '<img class="card-img" src="' .$res['img'] .'">';
							echo '<div class="card-body">';
							echo '<h5 class="card-title">' . $res['name'] . '</h5>';
							echo '<h6 class="card-subtitle mb-2 text-muted">' . $res['shortname'] . '</h6>';
							echo '<p class="card-text">' . f2s($res['value']) . ' ' . $res['shortname'] . ' = ' . number_format((float)$val, 2, '.', '') . ' <i class="fas fa-dollar-sign"></i></p>';
							echo('<a href="#" class="card-link">Trocar</a>');
							echo('<a href="#" class="card-link">Comprar</a>');
							echo '</div>';
							echo '</div>';
						}
					}
					if($last)
					{
						echo('</div>');
					}
				}				

				$totval = number_format((float)$totval, 2, '.', '');
				echo('<p class="card-text bg-dark text-white">Fiat + Spot</p>');
				echo '<div class="card bg-dark text-white">';					
				echo '<div class="card-body">';
				echo '<h5 class="card-title">' . 'Total' . '</h5>';
				echo '<h6 class="card-subtitle mb-2 text-muted">USD</h6>';
				echo '<p class="card-text">' . f2s($totval) . ' <i class="fas fa-dollar-sign"></i></p>';
				echo '</div>';
				echo '</div>';

			}
			?>
		</div>
	</body>
</html>