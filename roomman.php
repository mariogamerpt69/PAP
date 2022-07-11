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
        if(isset($_POST["number"], $_POST["pav"])) {
            include_once('config.php');
            if($stmt = $con->prepare("INSERT INTO `classroom` (`pavilhao`, `numero`) VALUES (?, ?)")) {
                $stmt->bind_param('ss', $_POST["number"], $_POST["pav"]);
                $stmt->execute();
                $stmt->store_result();
                $stmt->close();
            } else {
                $_SESSION['title'] = "Criar Sala";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Criar Sala";
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
                if($stmt = $con->prepare("DELETE FROM users WHERE id = ?")) {
                    $stmt->bind_param('i', $_POST['id']);
                    $stmt->execute();
                    if($stmt->affected_rows != 0) {
                        if(!isset($_POST["ref"])) {
                            $_SESSION['title'] = "Remover Sala";
                            $_SESSION['success'] = "Sala Removida";
                            header("location: /");
                        } else {
                            $_SESSION['title'] = "Remover Sala";
                            $_SESSION['success'] = "Sala Removida";
                            header("location: " . $_POST["ref"]);
                        }
                    } else {
                        $_SESSION['title'] = "Remover Sala";
                        $_SESSION['error'] = "Não Pode apagar uma sala com matrial associado";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Remover Sala";
                    $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Remover Sala";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Remover Sala";
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
        if(isset($_POST['id'], $_POST['number'], $_POST['pav'])) {
            if(is_numeric($_POST["id"])) {
                include_once('config.php');
                if($stmt = $con->prepare("UPDATE `classroom` SET `numero` = ?, `pavilhao` = ? WHERE `id` = ?")) {
                    $stmt->bind_param('ssi', $_POST['number'], $_POST['pav'], $_POST['id']);
                    $stmt->execute();
                    if($stmt->affected_rows != 0) {
                        $_SESSION['title'] = "Editar Sala";
                        $_SESSION['success'] = "Sala Editada com Sucesso";
                        header("location: /");
                    } else {
                        $_SESSION['title'] = "Editar Sala";
                        $_SESSION['error'] = "Nenhuma alteração efetuada";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Editar Sala";
                    $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Editar Sala";
                $_SESSION['error'] = "O id tem que ser um numero";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Editar Sala";
            $_SESSION['error'] = "Insira todos os dados";
            header("location: /");
        }
    } else {
        header("location: /");
        exit;
    }
}
?>