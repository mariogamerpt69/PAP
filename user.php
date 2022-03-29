<?php
session_start();
if(!isset($_SESSION["loggedin"])) {
    header("location: /");
    exit();
}

if($_SESSION["loggedin"] !== true) {
    header("location: /");
    exit();
}

if($_SESSION["perm"] !== "superuser" && $_SESSION["perm"] !== "owner") {
    header("location: /");
    exit();
}

if(!isset($_POST["type"])) {
    header("location: /");
    exit();
}

if($_POST['type'] == "add") {
    add();
} elseif($_POST['type'] == "rem") {
    remove();
} elseif($_POST['type'] == "edit") {
    edit();
} else {
    header("location: /");
    exit();
} 

function add() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_POST["username"], $_POST["password"], $_POST["mail"], $_POST["perm"])) {
            include_once('config.php');
            if($stmt = $con->prepare("SELECT 1 FROM users WHERE username = ? OR email = ?")) {+
                $stmt->bind_param('ss', $_POST["username"], $_POST["mail"]);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0) {
                    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    if($insert = $con->prepare("INSERT INTO `users` (`username`, `password`, `email`, `perm`) VALUES (?, ?, ?, ?)")) {
                        $insert->bind_param('ssss', $_POST['username'], $password_hash, $_POST['email'], $_POST['perm']);
                        $insert->execute();
                        $insert->close();
                    } else {
                        $_SESSION['title'] = "Criar Utilizador";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Criar Utilizador";
                    $_SESSION['error'] = "Este Utilizador já existe";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Criar Utilizador";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Criar Utilizador";
            $_SESSION['error'] = "Por Favor Insira todos os dados";
            header("location: /");
        }
    } else {
        header("location: /");
        exit;
    }
}

function remove() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['id'])) {
            if(is_numeric($_POST["id"])) {
                if($_POST['id'] == $_SESSION['id']) {
                    $_SESSION['error'] = "Não pode remover a si mesmo";
                } else {
                    include_once('config.php');
                    if($stmt = $con->prepare("DELETE FROM users WHERE id = ?")) {
                        $stmt->bind_param('i', $_POST['id']);
                        $stmt->execute();
                        if($stmt->affected_rows != 0) {
                            if(!isset($_POST["ref"])) {
                                $_SESSION['title'] = "Remover Utilizador";
                                $_SESSION['success'] = "Utilizador Removido";
                                header("location: /");
                            } else {
                                $_SESSION['title'] = "Remover Utilizador";
                                $_SESSION['success'] = "Utilizador Removido";
                                header("location: " . $_POST["ref"]);
                            }
                        } else {
                            $_SESSION['title'] = "Remover Utilizador";
                            $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                            header("location: /");
                        }
                    } else {
                        $_SESSION['title'] = "Remover Utilizador";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                    $stmt->close();
                }
            } else {
                $_SESSION['title'] = "Remover Utilizador";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Remover Utilizador";
            $_SESSION['error'] = "Insira todos os dados";
            header("location: /");
        }
    } else {
        header("location: /");
        exit;
    }
}

function edit() {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
    } else {
        header("location: /");
        exit;
    }
}
?>