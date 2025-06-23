<?php require_once("config.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IA-Polis</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png"/>
    <link rel="stylesheet" href="assets/css/styles.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>

<!-- /#right-panel -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/app.min.js"></script>
<!--<script src="assets/libs/apexcharts/dist/apexcharts.min.js"></script>-->
<script src="assets/libs/simplebar/dist/simplebar.js"></script>
<!--<script src="assets/js/dashboard.js"></script>-->


<!-- dataTable -->
<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/jszip.min.js"></script>
<script src="assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="assets/js/init/datatables-init.js"></script>

<!-- moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- jquery.mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar invisible">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="admin.php" class="text-nowrap logo-img">
                    <img src="assets/images/logos/favicon.png" width="180" alt=""/>
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="admin.php" aria-expanded="false">
                            <span>
                              <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <?
                    $papelUsuario = new Classe\PapelUsuario();
                    $colPapelUsuario = new Config\phpCollection();
                    $colPapelUsuario = $papelUsuario->carregarTodosCriterio("codUsuario", $_SESSION['CODIGOUSUARIO']);
                    if ($colPapelUsuario->length > 0) {
                        do {
                            $papel = new Classe\Papel();
                            $papel->setCodPapel($colPapelUsuario->current()->getCodPapel());
                            $papel->carregar();
                            //PORTAL
                            if ($colPapelUsuario->current()->getCodPapel() == 1) {
                                ?>
                                <li class="nav-small-cap">
                                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                    <span class="hide-menu"><?= $papel->getNome(); ?></span>
                                </li>
                                <?
                                if (isset($_SESSION['PERMISSOES']['listarFuncionalidade'])) {
                                    ?>
                                    <li class="sidebar-item funcionalidades">
                                        <a class="sidebar-link " href="#/funcionalidades" aria-expanded="false">
                                            <span>
                                              <i class="ti ti-panel"></i>
                                            </span>
                                            <span class="hide-menu">Funcionalidades</span>
                                        </a>
                                    </li>
                                    <?
                                } ?>
                                <?
                                if (isset($_SESSION['PERMISSOES']['listarPapel'])) {
                                    ?>
                                    <li class="sidebar-item papeis">
                                        <a class="sidebar-link " href="#/papeis" aria-expanded="false">
                                        <span>
                                          <i class="ti ti-file"></i>
                                        </span>
                                        <span class="hide-menu">Papeis</span>
                                    </a>
                                    </li><?
                                } ?>
                                <?
                                if (isset($_SESSION['PERMISSOES']['listarUsuario'])) {
                                    ?>
                                    <li class="sidebar-item usuarios">
                                        <a class="sidebar-link " href="#/usuarios" aria-expanded="false">
                                    <span>
                                      <i class="ti ti-user"></i>
                                    </span>
                                            <span class="hide-menu">Usuarios</span>
                                        </a>
                                    </li><?
                                } ?>
                                <?
                            } //DEMAIS PAPEIS
                            else if ($papel->getNome() == "Simulador") {
                                ?>
                                <li class="nav-small-cap">
                                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                    <span class="hide-menu"><?= $papel->getNome(); ?></span>
                                </li>
                                <?
                                if (isset($_SESSION['PERMISSOES']['listarCidadao'])) {
                                    ?>
                                    <li class="sidebar-item listarCidadao">
                                        <a class="sidebar-link" href="#/listarCidadao" aria-expanded="false">
                                            <span>
                                              <i class="ti ti-ruler-pencil"></i>
                                            </span>
                                            <span class="hide-menu">Cidadãos</span>
                                        </a>
                                    </li>
                                    <?
                                }
                            }
                        } while ($colPapelUsuario->has_next());
                    }
                    ?>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Informativos</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="https://youtu.be/oVuk47qnA-4" aria-expanded="false">
                            <span>
                              <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Vídeo introdutório</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="https://airtable.com/appee6TPRY1lyHNOQ/pag9qHuyWmfgKFuL4/form" aria-expanded="false">
                            <span>
                              <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Formulário de Feedback</span>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                     class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                 aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="#" class="d-flex align-items-center gap-2 dropdown-item" id="meuPerfil">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">Meu Perfil</p>
                                    </a>
                                    <a href="#"
                                       class="btn btn-outline-primary mx-3 mt-2 d-block" id="logoff">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--Local Stuff-->
        <script>
            $(document).ready(function () {
                $("form").submit(function(e){
                    e.preventDefault();
                    return false;
                });
                $('.funcionalidades').on('click', function () {
                    overlayStart();
                    $.post("frm/listarFuncionalidade.php", {}, function (resultado) {
                        $('.block_gr').html(resultado);
                        overlayStop();
                    });
                });
                $('.papeis').on('click', function () {
                    overlayStart();
                    $.post("frm/listarPapel.php", {}, function (resultado) {
                        $('.block_gr').html(resultado);
                        overlayStop();
                    });
                });
                $('.usuarios').on('click', function () {
                    overlayStart();
                    $.post("frm/listarUsuario.php", {}, function (resultado) {
                        $('.block_gr').html(resultado);
                        overlayStop();
                    });
                });
                $('.listarCidadao').on('click', function () {

                    overlayStart();
                    $.post("frm/listarCidadao.php", {}, function (resultado) {
                        $('.block_gr').html(resultado);
                        overlayStop();
                    });
                });

                <?
                if ($colPapelUsuario->current()->getCodPapel() == 1 || $_SESSION['CODIGOUSUARIO'] == 1) {
                ?>
                $.post("frm/pictograma_testeCompreensibildiade_lista.php", {}, function (resultado) {
                    $('.block_gr').html(resultado);
                });
                <?
                }else{
                ?>
                $.post("frm/listarReceituarioV2.php", {}, function (resultado) {
                    $('.block_gr').html(resultado);
                });
                <?
                }
                ?>
            });
        </script>
        <!--  Header End -->