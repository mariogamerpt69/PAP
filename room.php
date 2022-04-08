<?php
    session_start();
    if(!isset($_SESSION['loggedin']) ) {
        header('location: /');
        exit;
    }
    $action = "Ver Salas";
    $error = "";
    $jserror = "";
    $success = false;
    if(isset($_GET["action"])) {
        if($_GET["action"] == "see") {
            $action = "Ver Salas";
        } elseif($_GET["action"] == "add") {
            $action = "Adicionar Salas";
        } elseif($_GET["action"] == "rem") {
            $action = "Remover Salas";
        } else {
            $action = "Ver Salas";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-PT">
    <head>
        <meta charset="utf-8" />
        <title>School Management</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />    </head>
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
                        <li><a class="dropdown-item" href="/user-settings.php">Configurações</a></li>
                        <li><hr class="dropdown-divider" /></li>
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
                        <h1 class="mt-4">Gestão de Salas/Pavilhões</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $action ?></li>
                        </ol>
                    </div>
                    <div class="content bg-dark text-white">
                        <?php
                        if($action == "Adicionar Salas") {
                            echo '<div class="card-text bg-dark text-white">
                                <form action="/usermanagement.php" method="POST">
                                    <label for="number" class="form-label">Nome: </label>
                                    <input type="text" name="number" placeholder="Numero" id="number" required class="form-control w-25">
                                    <br>
                                    <label for="pav" class="form-label">Pavilhão: </label>
                                    <select class="form-select w-25" id="pav" name="pav">
                                    ';

                            include_once('config.php');
                            
                            if($stmt = $con->prepare('SELECT id, pavilhao FROM pavilhoes;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $pav);
                                while($stmt->fetch()) {
                                    echo '<option class="form-control w-25" value="' . $id . '">' . $pav . '</option>';
                                }
                            }

                            echo   '</select>
                                    <br>
                                    <input type="hidden" name="type" value="add">
                                    <button type="submit" class="btn btn-primary">Criar Conta</button>
                                </form>
                            </div>';
                        } elseif($action == "Remover Salas") {
                            echo '<div class="card-text bg-dark text-white">
                            <form action="/user.php" method="POST">
                            <label for="userid" class="form-label">Utilizador: </label>
                            <select class="form-select w-25" id="id" name="id">';

                            include_once('config.php');

                            if($stmt = $con->prepare('SELECT classroom.id, pavilhoes.pavilhao, numero FROM classroom INNER JOIN pavilhoes ON classroom. ORDER BY id ASC;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $pav, $num);
                                while($stmt->fetch()) {
                                    echo '<option class="form-control w-25" value="' . $id . '">' . $name . '</option>';
                                }
                            }

                            echo   '</select>
                                    <br>
                                        <button type="submit" class="btn btn-primary">Remover Utilizador</button>
                                </form>
                            </div>';


                        } elseif($action == "Ver Salas") {
                            include_once('config.php');
                            echo '<div class="card mb-4 text-dark">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pavilhão</th>
                                            <th>Numero</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pavilhão</th>
                                            <th>Numero</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>';

                            if($stmt = $con->prepare('SELECT classroom.id, pavilhoes.pavilhao, numero FROM classroom INNER JOIN pavilhoes ON classroom.pavilhao = pavilhoes.id ORDER BY classroom.id ASC;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $pav, $num);
                                while($stmt->fetch()) {
                                    echo '<tr>';
                                    echo "<td>". $id ."</td>";
                                    echo "<td>". $pav ."</td>";
                                    echo "<td>". $num ."</td>";
                                    if($_SESSION['perm'] == "superadmin" || $_SESSION['perm'] == "owner") {
                                        $sheesh = "'";
                                        echo '<td><button class="btn btn-danger" onclick="alert('. $sheesh .'relou'. $sheesh .')"><i class="fa-solid fa-x"></i> Remover</button></td>';
                                    } else {
                                        echo '<td><button class="btn btn-danger disabled" role="button" aria-disabled="true"><i class="fa-solid fa-x"></i> Remover</button></td>';
                                    }
                                    echo "</tr>";
                                }
                                echo "</tbody>
                                </table>
                                </div>
                                </div>";
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
        <script>
            window.addEventListener('DOMContentLoaded', event => {
                const datatablesSimple = document.getElementById('datatablesSimple');
                if (datatablesSimple) {
                    new simpleDatatables.DataTable(datatablesSimple);
                }
            });
        </script>
    </body>
</html>
