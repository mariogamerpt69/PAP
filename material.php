<?php
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('location: /');
        exit;
    }
    $action = "Ver Material";
    $error = "";
    $jserror = "";
    $success = false;
    if(isset($_GET["action"])) {
        if($_GET["action"] == "see") {
            $action = "Ver Material";
        } elseif($_GET["action"] == "add") {
            $action = "Adicionar Material";
        } elseif($_GET["action"] == "edit") {
            $action = "Editar Material";
            if (!isset($_GET["id"])) {
                header('location: /room.php');
                exit();
            }
        } else {
            $action = "Ver Material";
        }
    }
    include_once('config.php');
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["username"], $_POST["password"], $_POST["mail"])) {
            if($stmt = $con->prepare("SELECT 1 FROM users WHERE username = ? OR email = ?")) {
                $stmt->bind_param('ss', $_POST["username"], $_POST["mail"]);
                $stmt->execute();
                $stmt->store_result();
                if($stmt->num_rows == 0) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['mail'];
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    if($insert = $con->prepare("INSERT INTO `users` (`username`, `password`, `email`) VALUES (?, ?, ?)")) {
                        $insert->bind_param('sss', $username, $password_hash, $email);
                        $insert->execute();
                        $insert->close();
                        $success = true;
                    } else {
                        $error = "Erro na base de dados, Contacte um administrador para mais informações";
                        $jserror = "SQL2";
                    }
                    $stmt->close();
                } else {
                    $error = "Já existe alguem com esse nome de utilizador ou email";
                    $jserror = "same username or mail";
                }
            } else {
                $error = "Erro na base de dados, Contacte um administrador para mais informações";
                $jserror = "SQL1";
            }
        } else {
            $error = "Insira todos os valores";
            $jserror = "values";
        }
    } else {

    }

?>
<!DOCTYPE html>
<html lang="pt-PT">
    <head>
        <meta charset="utf-8" />
        <title>School Management</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="/">School Management</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                       <li><a class="dropdown-item" href="/logout.php">Terminar Sessão</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link" href="/">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                                School Management
                            </a>
                            <div class="sb-sidenav-menu-heading">Gestão de Salas/Pavilhões</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard"></i></div>
                                Gerir Salas/Pavilhões
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="room.php">Ver Salas</a>
                                    <a class="nav-link" href="room.php?action=add">Adicionar Sala</a>
                                    <a class="nav-link" href="pav.php">Ver Pavilhões</a>
                                    <a class="nav-link" href="pav.php?action=add">Adicionar Pavilhões</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Gestão de Material</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard"></i></div>
                                Gerir Material
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="material.php">Ver Material</a>
                                    <a class="nav-link" href="material.php?action=add">Adicionar Material</a>
                                    <a class="nav-link" href="pcs.php">Ver Computadores</a>
                                    <a class="nav-link" href="pcs.php?action=add">Adicionar Computadores</a>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Administração</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts3" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Gerir Utilizadores
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="usermanagement.php">Ver Utilizadores</a>
                                    <a class="nav-link" href="usermanagement.php?action=add">Adicionar Utilizadores</a>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logado como:</div>
                        <?php 
                            if(!isset($_SESSION['loggedin'])) {
                                echo "<a href = '/login.php'>Iniciar Sessão</a>";
                            } else {
                                echo $_SESSION['username'];
                            }
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content" class="content bg-dark text-white">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Gestão de Material</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $action ?></li>
                        </ol>
                    </div>
                    <div class="content bg-dark text-white">
                        <?php
                        if($action == "Adicionar Material") {
                            echo '<div class="card-text bg-dark text-white">
                                <form action="/matman.php" method="POST">
                                    <label for="nombre" class="form-label">Nome do Material: </label>
                                    <input type="text" name="nombre" placeholder="Nome do Material" id="nombre" required class="form-control w-25">
                                    <br>
                                    <label for="tipo" class="form-label">Tipo: </label>
                                    <select class="form-select w-25" id="tipo" name="tipo">';

                            include_once('config.php');
                            
                            if($stmt = $con->prepare('SELECT id, type FROM type;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $type);
                                while($stmt->fetch()) {
                                    echo '<option class="form-control w-25" value="' . $id . '">' . $id . " - " . $type . '</option>';
                                }
                                $stmt->close();
                            }
                            
                            echo   '</select>
                                    <br>
                                    <label for="room" class="form-label">Sala: </label>
                                    <select class="form-select w-25" id="room" name="room">';

                            if($stmt = $con->prepare('SELECT classroom.id, pavilhoes.pavilhao, numero FROM classroom INNER JOIN pavilhoes ON classroom.pavilhao = pavilhoes.id;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $pav, $num);
                                while($stmt->fetch()) {
                                    echo '<option class="form-control w-25" value="' . $id . '">' . $pav . ' - ' . $num . '</option>';
                                }
                                $stmt->close();
                            }

                            echo   '</select>
                                    <br>
                                    <input type="hidden" name="type" value="add">
                                    <button type="submit" class="btn btn-primary">Adicionar Material</button>
                                </form>
                            </div>';
                        } elseif($action == "Ver Material") {
                            include_once('config.php');
                            echo '<div class="card mb-4 text-dark">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Pavilhão</th>
                                            <th>Sala</th>
                                            <th>Computador</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Tipo</th>
                                            <th>Pavilhão</th>
                                            <th>Sala</th>
                                            <th>Computador</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>';

                            if($stmt = $con->prepare('SELECT material.id, name, type.type, pavilhoes.pavilhao, classroom.numero, computerid FROM material INNER JOIN type ON type.id = material.type INNER JOIN classroom ON classroom.id = material.room INNER JOIN pavilhoes ON pavilhoes.id = classroom.pavilhao ;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $name, $type, $pav, $room, $computer);
                                while($stmt->fetch()) {
                                    $sheesh = '"';
                                    echo "<tr>
                                    <td>". $id ."</td>
                                    <td>". $name ."</td>
                                    <td>". $type ."</td>
                                    <td>". $pav ."</td>
                                    <td>". $room ."</td>";
                                    if ($computer == null) {
                                        echo "<td>$computer</td>";
                                    } else {
                                        echo "<td><a href='/computer.php?id=$computer'>$computer</a></td>";
                                    }
                                    echo "<td><button class='btn btn-danger' onclick='postModal($id, $sheesh$name$sheesh)'><i class='fa-solid fa-x'></i> Remover</button>";
                                    echo " <button class='btn btn-primary' onclick='window.location.href = $sheesh/material.php?action=edit&id=$id$sheesh'><i class='fa-solid fa-x'></i> Editar</button>";
                                    if($computer == null) {
                                        $link = '"/asspc.php?id=' . $id . '"';
                                        echo " <button class='btn btn-primary' onclick='location.replace($link)'><i class='fa-solid fa-x'></i> Associar Computador</button>";
                                    }
                                    echo "</td>
                                </tr>";
                                }
                            }
                            echo "</tbody>
                                </table>
                                </div>
                                </div>";
                        }elseif($action == "Editar Material") {
                            include_once('config.php');
                            if($stmt = $con->prepare("SELECT name, type, room, computerid FROM material WHERE id = ?;"))
                            {
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($name, $typeid, $roomid, $computerid);
                                $stmt->fetch();
                                echo '<div class="card-text bg-dark text-white">
                                    <form action="/matman.php" method="POST">
                                        <label for="nombre" class="form-label">Nome do Material: </label>
                                        <input type="text" name="nombre" placeholder="Nome do Material" id="nombre" value="' . $name . '" required class="form-control w-25">
                                        <br>
                                        <label for="tipo" class="form-label">Tipo: </label>
                                        <select class="form-select w-25" id="tipo" name="tipo">';
                                if($select = $con->prepare('SELECT id, type FROM type;')) {
                                    $select->execute();
                                    $select->store_result();
                                    $select->bind_result($id, $type);
                                    while($select->fetch()) {
                                        if($id == $typeid)
                                        {
                                            echo '<option class="form-control w-25" value="' . $id . '" selected>' . $id . " - " . $type . '</option>';
                                        }
                                        else
                                        {
                                            echo '<option class="form-control w-25" value="' . $id . '" >' . $id . " - " . $type . '</option>';
                                        }
                                    }
                                    $select->close();
                                }
                                
                                echo   '</select>
                                        <br>
                                        <label for="room" class="form-label">Sala: </label>
                                        <select class="form-select w-25" id="room" name="room">';

                                if($select = $con->prepare('SELECT classroom.id, pavilhoes.pavilhao, numero FROM classroom INNER JOIN pavilhoes ON classroom.pavilhao = pavilhoes.id;')) {
                                    $select->execute();
                                    $select->store_result();
                                    $select->bind_result($id, $pav, $num);
                                    while($select->fetch()) {
                                        if($id == $roomid)
                                        {
                                            echo '<option class="form-control w-25" value="' . $id . '" selected>' . $pav . ' - ' . $num . '</option>';
                                        }
                                        else
                                        {
                                            echo '<option class="form-control w-25" value="' . $id . '">' . $pav . ' - ' . $num . '</option>';
                                        }
                                    }
                                    $select->close();
                                }

                                echo   '</select>
                                        <br>
                                        <input type="hidden" name="type" value="edit">
                                        <input type="hidden" name="id" value="' . $_GET['id'] . '">
                                        <button type="submit" class="btn btn-primary">Editar Material</button>
                                    </form>
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </main>
                <footer class="py-4 bg-grey mt-auto" style="background-color: #343a40">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; School Management 2022</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
	    <script src="js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="js/modalcreator.bootstrap.js"></script>
        <script src="js/simple-datatables.js"></script>
        <script src="js/datatable.js"></script>
        <script>
            window.addEventListener('DOMContentLoaded', event => {
                const datatablesSimple = document.getElementById('datatablesSimple');
                if (datatablesSimple) {
                    new simpleDatatables.DataTable(datatablesSimple);
                }
            });
        </script>
        <script>
            function postModal(id, name) {
                let postdata = { "type": "rem", "id": id, "ref": window.location.href };
                showPostModal('Remover Material', `Tem a certeza que pretende remover ${name}?`, 'Remover', 'Cancelar', "/matman.php", postdata, cb = function() {});
            }

            $(document).ready(function() {
                let a = 0;
                <?php
                if(isset($_SESSION['error'])) {
                    if(!isset($_SESSION['title'])) {
                        echo 'show1btnModal("Alerta", "' . $_SESSION['error'] . '", "Fechar")';
                    } else {
                        echo 'show1btnModal("' . $_SESSION['title'] . '", "' . $_SESSION['error'] . '", "Fechar")';
                    }
                    $_SESSION['error'] = null;
                    $_SESSION['title'] = null;
                }
                if(isset($_SESSION['success'])) {
                    if(!isset($_SESSION['title'])) {
                        echo 'show1btnModal("Alerta", "' . $_SESSION['success'] . '", "Fechar")';
                    } else {
                        echo 'show1btnModal("' . $_SESSION['title'] . '", "' . $_SESSION['success'] . '", "Fechar")';
                    }
                    $_SESSION['success'] = null;
                    $_SESSION['title'] = null;
                }
                ?>
            });
        </script>
    </body>
</html>
