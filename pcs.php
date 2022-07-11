<?php
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('location: /');
        exit;
    }
    $action = "Ver Computadores";
    if(isset($_GET["action"])) {
        if($_GET["action"] == "see") {
            $action = "Ver Computadores";
        } elseif($_GET["action"] == "add") {
            $action = "Adicionar Computadores";
        } elseif($_GET["action"] == "edit") {
            $action = "Editar Computadores";
            if (!isset($_GET["id"])) {
                header('location: /room.php');
                exit();
            }
        } else {
            $action = "Ver Computadores";
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
                        <h1 class="mt-4">Gestão de Computadores</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo $action ?></li>
                        </ol>
                    </div>
                    <div class="content bg-dark text-white">
                        <?php
                        if($action == "Adicionar Computadores") {
                            echo '<div class="card-text bg-dark text-white">
                                <form action="/pc.php" method="POST">
                                    <label for="identifier" class="form-label">Identificador: </label>
                                    <input type="text" name="identifier" placeholder="Identificador" id="identifier" required class="form-control w-25">
                                    <br>
                                    <label for="room" class="form-label">Sala: </label>
                                    <select class="form-select w-25" id="room" name="room">
                                    ';
                            include_once('config.php');
                            if($stmt = $con->prepare("SELECT classroom.id, classroom.numero, pavilhoes.pavilhao FROM classroom inner join pavilhoes on classroom.pavilhao = pavilhoes.id;")) {
                                $stmt->execute();
                                $stmt->bind_result($id, $numero, $pav);
                                while($stmt->fetch()) {
                                    echo '<option value="'.$id.'">' . $pav . " - " .$numero.'</option>';
                                }
                            }
                            echo   '</select>
                                    <br>
                                    <input type="hidden" name="type" value="add">
                                    <button type="submit" class="btn btn-primary">Criar Computador</button>
                                </form>
                            </div>';
                        } elseif($action == "Ver Computadores") {
                            include_once('config.php');
                            echo '<div class="card mb-4 text-dark">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Identificador</th>
                                            <th>Sala</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Identificador</th>
                                            <th>Sala</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>';

                            if($stmt = $con->prepare('SELECT computers.id, computers.identifier, classroom.numero FROM computers INNER JOIN classroom on computers.room = classroom.id;')) {
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($id, $identifier, $classroom);
                                while($stmt->fetch()) {
                                    $sheesh = '"';
                                    $link = '"/computer.php?id=' . $id . '"';
                                    echo "<tr>
                                    <td>". $id ."</td>
                                    <td>". $identifier ."</td>
                                    <td>". $classroom ."</td>
                                    <td><button class='btn btn-danger' onclick=$sheesh postModal($id,'$identifier')$sheesh><i class='fa-solid fa-x'></i> Remover</button>
                                    <button class='btn btn-primary' onclick=$sheesh window.location.href = '/pcs.php?action=edit&id=$id'$sheesh><i class='fa-solid fa-pen'></i> Editar</button>
                                    <button class='btn btn-primary' onclick='location.replace($link)'><i class='fa-solid fa-eye'></i> Ver Material</button></>
                                    </tr>";
                                }
                            }
                            echo "</tbody>
                                </table>
                                </div>
                                </div>";
                        }
                        elseif($action == "Editar Computadores")
                        {
                            include_once('config.php');
                            if($stmt = $con->prepare("SELECT identifier, room FROM computers WHERE id=?"))
                            {
                                $stmt->bind_param("i", $_GET['id']);
                                $stmt->execute();
                                $stmt->store_result();
                                $stmt->bind_result($identifier, $roomid);
                                $stmt->fetch();
                                echo '<div class="card-text bg-dark text-white">
                                    <form action="/pc.php" method="POST">
                                    
                                        <label for="number" class="form-label">Identifier:</label>
                                        <input type="text" name="identifier" placeholder="Numero" id="number" required class="form-control w-25" value="' . $identifier . '">
                                        <br>
                                        <label for="pav" class="form-label">Sala: </label>
                                        <select class="form-select w-25" id="room" name="room">';
                                if($stmt = $con->prepare("SELECT classroom.id, classroom.numero, pavilhoes.pavilhao FROM classroom inner join pavilhoes on classroom.pavilhao = pavilhoes.id;")) {
                                    $stmt->execute();
                                    $stmt->bind_result($id, $numero, $pav);
                                    while($stmt->fetch()) {
                                        if($id == $roomid)
                                        {
                                            echo '<option value="'.$id.'" selected>' . $pav . " - " .$numero.'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$id.'">' . $pav . " - " .$numero.'</option>';
                                        }
                                    }
                                }
                                echo   '</select>
                                        <br>
                                        <input type="hidden" name="type" value="edit">
                                        <input type="hidden" name="id" value="' . $_GET['id'] . '">
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
                                </div>';
                            }
                            else
                            {
                                header("Location: /");
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

            function postModal(id, name) {
                let postdata = { "type": "rem", "id": id, "ref": window.location.href };
                showPostModal('Remover Computador', `Tem a certeza que pretende remover o computador ${name}?`, 'Remover', 'Cancelar', "/pc.php", postdata, cb = function() {});
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
