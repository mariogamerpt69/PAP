<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-PT">
    <head>
        <meta charset="utf-8" />
        <title>School Management</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <?php
                        if(isset($_SESSION['loggedin'])) {
                            echo '<li><a class="dropdown-item" href="/logout.php">Terminar Sessão</a></li>';
                        } else {
                            echo '<li><a class="dropdown-item" href="/login.php">Iniciar Sessão</a></li>';
                        }
                        ?>
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
                                    <?php
                                    if(isset($_SESSION['loggedin'])) {
                                        echo '<a class="nav-link" href="room.php">Ver Salas</a>
                                        <a class="nav-link" href="room.php?action=add">Adicionar Sala</a>
                                        <a class="nav-link" href="pav.php">Ver Pavilhões</a>
                                        <a class="nav-link" href="pav.php?action=add">Adicionar Pavilhões</a>';
                                    } else {
                                        echo '<a class="nav-link" href="#" onclick="alertas()">Ver Salas</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Adicionar Sala</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Ver Pavilhões</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Adicionar Pavilhões</a>'; 
                                    }
                                    ?>
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
                                    <?php
                                    if(isset($_SESSION['loggedin'])) {
                                        echo '<a class="nav-link" href="material.php">Ver Material</a>
                                        <a class="nav-link" href="material.php?action=add">Adicionar Material</a>
                                        <a class="nav-link" href="pcs.php">Ver Computadores</a>
                                        <a class="nav-link" href="pcs.php?action=add">Adicionar Computadores</a>';
                                    } else {
                                        $s = "'";
                                        echo '<a class="nav-link" href="#" onclick="alertas()">Ver Material</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Adicionar Material</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Ver Computadores</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Adicionar Computadores</a>'; 
                                    }
                                    ?>
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
                                    <?php
                                    if(isset($_SESSION['loggedin'])) {
                                        echo '<a class="nav-link" href="usermanagement.php">Ver Utilizadores</a>
                                        <a class="nav-link" href="usermanagement.php?action=add">Adicionar Utilizadores</a>';
                                    } elseif(isset($_SESSION['god']) OR isset($_SESSION['owner'])) {
                                        $s = "'";
                                        echo '<a class="nav-link" href="#" onclick="alertap()">Ver Utilizadores</a>
                                        <a class="nav-link" href="#" onclick="alertap()">Adicionar Utilizadores</a>'; 
                                    } else {
                                        $s = "'";
                                        echo '<a class="nav-link" href="#" onclick="alertas()">Ver Utilizadores</a>
                                        <a class="nav-link" href="#" onclick="alertas()">Adicionar Utilizadores</a>'; 
                                    }
                                    ?>
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
                    <?php
                    if(!isset($_SESSION['loggedin'])) {
                        echo '<div class="container-fluid px-4 bg-dark text-white">
                            <h1 class="mt-4">Para continuar <a href="/login.php">inicie sessão</a></h1>
                            <br>
                            <h5>Manter a organização no trabalho é um dos bons hábitos que todo profissional deve adotar. Afinal, ninguém deseja entregar uma tarefa depois do prazo, chegar atrasado a reuniões ou perder algum material importante, não é mesmo?</li>
                            <h5>A disciplina profissional, porém, não é importante apenas pensando na estabilidade da vida profissional. Ela é igualmente favorável para a lucratividade das empresas. Isso porque, quanto mais tempo o trabalhador passa arrumando o ambiente de trabalho, menos produtivo ele. E, portanto, menos lucros traz para o negócio.</li>
                            <br>
                            <br>
                            <img src="/img/2.png" alt="Image">
                            <br>
                            <br>
                            <img src="/img/1.png" alt="Image">
                        </div>';
                    } else {
                        include_once('config.php');
                        $pcs = 0;
                        $rooms = 0;
                        $pavs = 0;
                        $mats = 0;
                        $users = 0;
                        if($stmt = $con->prepare("SELECT COUNT(`id`) FROM `computers`")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $pcs = $count;
                            $stmt->close();
                        }
                        if($stmt = $con->prepare("SELECT COUNT(`id`) FROM `classroom`")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $rooms = $count;
                            $stmt->close();
                        }
                        if($stmt = $con->prepare("SELECT COUNT(`id`) FROM `pavilhoes`")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $pavs = $count;
                            $stmt->close();
                        }
                        if($stmt = $con->prepare("SELECT COUNT(`id`) FROM `material`")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $mats = $count;
                            $stmt->close();
                        }
                        if($stmt = $con->prepare("SELECT COUNT(`id`) FROM `users`")) {
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $users = $count;
                            $stmt->close();
                        }
                        echo '<div class="container-fluid px-4 bg-dark text-white">
                            <div class="card bg-dark text-white">
                                <div class="card-group">
                                    <div class="card-body">
                                        <h5 class="card-title">Numero total de PCs registados</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'. $pcs .' <i class="fa-solid fa-laptop-code"></i></h6>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Numero total de Salas registadas</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'. $rooms .' <i class="fa-solid fa-hotel"></i></h6>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Numero total de Pavilhões registados</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'. $pavs .' <i class="fa-solid fa-place-of-worship"></i></h6>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Numero total de Materias registados</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'. $mats .' <i class="fa-solid fa-floppy-disk"></i></h6>
                                    </div>  
                                    <div class="card-body">
                                        <h5 class="card-title">Numero total de Utilizadores registados</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">'. $users .' <i class="fa-solid fa-user"></i></h6>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
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
        <script>
            function alertas() {
                showModal('Alerta', "Tem que <a href='/login.php'>iniciar sessão</a> para continuar", "Iniciar Sessão", "Fechar", element => {
                    window.location = "/login.php";
                });
            }

            function alertap() {
                showModal('Alerta', "Não tens permição para aceder a este recurso", "Fechar", "Fechar");
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
