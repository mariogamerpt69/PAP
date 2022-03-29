<?php
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('location: /');
        exit;
    }
?>
<html>
<head>
<link href="css/styles.css" rel="stylesheet" />
<style>
body {
  background-color: black;
}
.center {
  text-align: center;
  border: 3px solid black;
  color: white;
}
</style>
</head>
<body>
    <div class="center" >
        <h1>JUST DEPRESS</h1>
        <button class="btn btn-primary" onclick="javascript:window.location='/'">Voltar</button>
    </div>
</body>