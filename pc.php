<?php
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('location: /');
        exit;
    }

    if($_SESSION["loggedin"] !== true) {
        header("location: /");
        exit();
    }
    
    if($_SESSION["perm"] !== "superuser" && $_SESSION["perm"] !== "owner") {
        header("location: /");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['type'])) {
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
        } else {
            header('location: /');
            exit;
        }
    } else {
        header('location: /');
        exit;
    }

    function add() {
        if(isset($_POST['identifier'], $_POST['room'])) {
            $identifier = $_POST['identifier'];
            include_once('config.php');
            if($stmt = $con->prepare("SELECT 1 FROM computers WHERE identifier = ?")) {
                $stmt->bind_param('s', $_POST['identifier']);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0) {
                    if($insert = $con->prepare("INSERT INTO `computers` (`identifier`, `room`) VALUES (?, ?)")) {
                        $insert->bind_param('ss', $_POST['identifier'], $_POST['room']);
                        $insert->execute();
                        $insert->close();
                        header("location: /pcs.php");
                    } else {
                        $_SESSION['title'] = "Adicionar Sala";
                        $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                        header("location: /");
                    }
                    $stmt->close();
                } else {
                    $_SESSION['title'] = "Adicionar Sala";
                    $_SESSION['error'] = "O Identificador $identifier já existe";
                    header("location: /");
                }
            } else {
                $_SESSION['title'] = "Adicionar Sala";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Adicionar Sala";
            $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
            header("location: /");
        }
    }

    function remove() {
        if(isset($_POST['id'])) {
            include_once('config.php');
            if($stmt = $con->prepare("DELETE FROM `computers` WHERE `id` = ?")) {
                $stmt->bind_param('i', $_POST['id']);
                $stmt->execute();
            } else {
                $_SESSION['title'] = "Remover Sala";
                $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
                header("location: /");
            }
        } else {
            $_SESSION['title'] = "Remover Sala";
            $_SESSION['error'] = "Erro na Base de Dados, Contacte um administrador";
            header("location: /");
        }
    }

    function edit() {

    }
?>