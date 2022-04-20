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
        if(isset($_POST["nombre"], $_POST["tipo"], $_POST["room"])) {
            include_once('config.php');
            if($stmt = $con->prepare("INSERT INTO `material` (`name`,`type`,`room`) VALUES (?,?,?)")) {
                $stmt->bind_param('sii', $_POST["nombre"], $_POST["tipo"], $_POST["room"]);
                $stmt->execute();
                header("location: /material.php");
            } else {
                $_SESSION['title'] = "Adicionar Material";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Adicionar Material";
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
                include_once('config.php');
                if($stmt = $con->prepare("DELETE FROM material WHERE id = ?")) {
                    $stmt->bind_param('i', $_POST['id']);
                    $stmt->execute();
                    if($stmt->affected_rows != 0) {
                        if(!isset($_POST["ref"])) {
                            $_SESSION['title'] = "Remover Material";
                            $_SESSION['success'] = "Material Removido";
                            header("location: /");
                        } else {
                            $_SESSION['title'] = "Remover Material";
                            $_SESSION['success'] = "Material Removido";
                            header("location: " . $_POST["ref"]);
                        }
                    } else {
                        $_SESSION['title'] = "Remover Material";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                } else {
                    $_SESSION['title'] = "Remover Material";
                    $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                    header("location: /");
                }
                $stmt->close();
            } else {
                $_SESSION['title'] = "Remover Material";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Remover Material";
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