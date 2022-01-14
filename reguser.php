<?php
include_once('db.php');

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Insere todos os dados!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Insere todos os dados!');
}
if ($stmt = $con->prepare('SELECT 1 FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo 'O username já existe!';
	} else {
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            $password = $_POST['password']; password_hash($_POST['password'], PASSWORD_DEFAULT);
			$hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $hash, $_POST['email']);
            $stmt->execute();
            echo 'Conta criada com sucesso <a href="login.php">Login</a>';
        } else {
            echo 'SQL ERROR!';
        }	
    }
	$stmt->close();
} else {
	echo 'SQL ERROR!';
}
$con->close();
?>