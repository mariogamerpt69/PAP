<?php
session_start();

if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Insere todos os dados!');
}

require_once('db.php');

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();
        $password = $_POST['password'];
        if (password_verify($password, $password_hash)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: index.php');
        } else {
            echo 'Password incorreta!';
        }
    } else {
        echo 'username não existe!';
    }

	$stmt->close();
}
?>