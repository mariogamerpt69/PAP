<?php
session_start();
include_once('db.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(empty($_POST['value'])) {
        $_SESSION['depositerror'] = 'Por favor, insira um valor.';
        header('Location: deposit.php');
        exit;
    }
    else if(empty($_POST['depmethod'])) {
        $_SESSION['depositerror'] = 'Por favor, selecione um metodo de pagamento.';
        header('Location: deposit.php');
        exit;
    }
    else if($_POST['value'] < 10) {
        $_SESSION['depositerror'] = "O valor minimo é 10.";
        header('Location: deposit.php');
        exit;
    }
    else {
        $value = $_POST['value'];
        $depmethod = $_POST['depmethod'];
        $userid = $_SESSION['id'];
        $sql = "INSERT INTO `deposits` (`userid`, `value`, `depmethod`) VALUES (?, ?, ?)";
        $stmt3 = $con->prepare($sql);
        $stmt3->bind_param('iis', $userid, $value, $depmethod);
        $stmt3->execute();
        $stmt3->close();
        $sql2 = "Update `accounts` SET `usd` = `usd` + ? WHERE `id` = ?";
        $stmt2 = $con->prepare($sql2);
        $stmt2->bind_param('ii', $value, $userid);
        $stmt2->execute();
        $stmt2->close();
        if($con) {
            $_SESSION['success'] = 'Deposito efetuado com sucesso!';
            header('Location: deposit.php');
            exit;
        }
        else {
            $_SESSION['error'] = 'Erro ao efetuar deposito.';
            header('Location: deposit.php');
            exit;
        }
    }
}

?>