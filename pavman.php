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
        if(isset($_POST["nombre"])) {
            include_once('config.php');
            if($stmt = $con->prepare("SELECT 1 FROM pavilhoes WHERE pavilhao = ?")) {+
                $stmt->bind_param('s', $_POST["nombre"]);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0) {
                    if($insert = $con->prepare("INSERT INTO `pavilhoes` (`pavilhao`) VALUES (?)")) {
                        $insert->bind_param('s', $_POST['nombre']);
                        $insert->execute();
                        $insert->close();
                        header("location: /pav.php");
                    } else {
                        $_SESSION['title'] = "Adicionar Pavilhão";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Adicionar Pavilhão";
                    $_SESSION['error'] = "Este Pavilhão já existe";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Adicionar Pavilhão";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Adicionar Pavilhão";
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
                if($stmt = $con->prepare("DELETE FROM pavilhoes WHERE id = ?")) {
                    $stmt->bind_param('i', $_POST['id']);
                    $stmt->execute();
                    if($stmt->affected_rows != 0) {
                        if(!isset($_POST["ref"])) {
                            $_SESSION['title'] = "Remover Pavilhão";
                            $_SESSION['success'] = "Pavilhão Removido";
                            header("location: /");
                        } else {
                            $_SESSION['title'] = "Remover Pavilhão";
                            $_SESSION['success'] = "Pavilhão Removido";
                            header("location: " . $_POST["ref"]);
                        }
                    } else {
                        $_SESSION['title'] = "Remover Pavilhão";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                } else {
                    $_SESSION['title'] = "Remover Pavilhão";
                    $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                    header("location: /");
                }
                $stmt->close();
            } else {
                $_SESSION['title'] = "Remover Pavilhão";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Remover Pavilhão";
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
        if(isset($_POST['id'], $_POST['number'])) {
            if(is_numeric($_POST["id"])) {
                include_once('config.php');
                if($stmt = $con->prepare("UPDATE `pavilhoes` SET `pavilhao` = ? WHERE `id` = ?")) {
                    $stmt->bind_param('si', $_POST['number'], $_POST['id']);
                    $stmt->execute();
                    if($stmt->affected_rows != 0) {
                        $_SESSION['title'] = "Editar Pavilhão";
                        $_SESSION['success'] = "Pavilhão Editada com Sucesso";
                        header("location: /");
                    } else {
                        $_SESSION['title'] = "Editar Pavilhão";
                        $_SESSION['error'] = "Nenhuma alteração efetuada";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Editar Pavilhão";
                    $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Editar Pavilhão";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Editar Pavilhão";
            $_SESSION['error'] = "Insira todos os dados";
            header("location: /");
        }
    } else {
        header("location: /");
        exit;
    }
}
?>