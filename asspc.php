<?php
    session_start();
    if(!isset($_SESSION['loggedin'])) {
        header('location: /');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['pc'], $_POST['mat'])){
            include_once('config.php');
            if($stmt = $con->prepare("UPDATE material set computerid = ? WHERE id = ?")) {
                $stmt->bind_param("ii", $_POST['pc'], $_POST['mat']);
                $stmt->execute();
                header("location: /material.php");
                exit;
            }
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
                        <h1 class="mt-4">Associar Material ao PC</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Material->PC</li>
                        </ol>
                    </div>
                    <div class="content bg-dark text-white">
                        <?php
                            if(isset($_GET['id'])) {
                                $mat = $_GET['id'];
                                include_once('config.php');
                                $name = $room = null;
                                if($stmt = $con->prepare("SELECT name, room FROM material WHERE id = ?")){
                                    $stmt->bind_param("i", $_GET['id']);
                                    $stmt->execute();
                                    $stmt->bind_result($a, $b);
                                    $stmt->fetch();
                                    echo("Associar $name a:");
                                    $name = $a;
                                    $room = $b;
                                    $stmt->close();
                                }
                                echo("<form method='POST'>");
                                echo("<input type='hidden' id='mat' name='mat' value='$mat'>");
                                echo("<select class='form-select w-25' id='pc' name='pc' aria-label='escolhe um computador da lista'>");
                                if($stmt = $con->prepare('SELECT id, identifier FROM computers WHERE room = ?')) {
                                    $stmt->bind_param("i", $room);
                                    $stmt->execute();
                                    $stmt->bind_result($id, $identifier);
                                    while($stmt->fetch()){
                                        echo("<option class='form-control w-25' value='$id'>$identifier</option>");
                                    }
                                }
                                echo("</select>");
                                echo("<button type='submit' class='btn btn-primary'>Associar</button>");
                                echo("</form>");
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
                showPostModal('Remover Utilizador', `Tem a certeza que pretende remover ${name}?`, 'Remover', 'Cancelar', "/matman.php", postdata, cb = function() {});
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
                ?>
            });
        </script>
    </body>
</html>
