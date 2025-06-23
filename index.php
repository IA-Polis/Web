<? require_once("config/config.php");
if (isset($_SESSION['LOGADO']) && $_SESSION['LOGADO']) header("Location: http://" . $GLOBALS['NOMESERVIDOR'] . "/admin.php");
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IA-Polis</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
    <?
    if (isset($_GET['verificado']) && !empty($_GET['verificado'])) {
        $usuario = new Classe\Usuario();
    if ($usuario->verificarUid($_GET['verificado'])) {
        $usuario->setVerificado(1);
        $usuario->setTrocaSenha("");
        $usuario->salvar();
        ?>
        <script type="text/javascript">
            $().ready(function () {
                $('#message').html("<div class=\"alert alert-success text-center\ role=\"alert\">Usuário verificado com sucesso! Logue-se para entrar no sistema.</div>");
            });
        </script>
    <?
    }
    }
    else if (isset($_GET['recuperar']) && !empty($_GET['recuperar']))
    {
    $usuario = new Classe\Usuario();
    if ($usuario->verificarUid($_GET['recuperar']))
    {
    ?>
        <script type="text/javascript">
            token = "<?=$_GET['recuperar'];?>";
            $().ready(function () {
                $('#message').html("<div class=\"alert alert-info text-center\ role=\"alert\">Utilize o formulário abaixo para trocar sua senha.</div>");
                $('.toolbar').addClass('hide');//hide others
                $('#passwordChangeTab').removeClass('hide');//show target
            });
        </script>
        <?
    }
    }
    ?>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="admin.php" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="assets/images/logos/favicon.png" width="180" alt="">
                </a>
                <p class="text-center">IA-Polis</p>
                  <div id="message"></div>
                <form>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" name="usuario" id="usuario" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="lembrar-dados" checked>
                      <label class="form-check-label text-dark" for=id="lembrar-dados">
                          Lembrar
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="admin.php">Esqueceu a senha?</a>
                  </div>
                  <a href="#" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" id="enviarLoginUsuario">Entrar</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript">
        $().ready(function () {

            if(typeof localStorage.getItem('lembrar-dados') !== "undefined" && localStorage.getItem('lembrar-dados') == "true")
            {
                $('#usuario').val(localStorage.getItem('usuario'));
                $('#senha').val(localStorage.getItem('senha'));
                $('#lembrar-dados').prop('checked',true);
            }

            $('#enviarLoginUsuario').click(function (e) {
                e.preventDefault();
                if($('#lembrar-dados').prop('checked'))
                {
                    localStorage.setItem('lembrar-dados',true);
                    localStorage.setItem('usuario',$('#usuario').val());
                    localStorage.setItem('senha',$('#senha').val());
                }
                else
                {
                    localStorage.setItem('lembrar-dados',false);
                    localStorage.setItem('usuario',"");
                    localStorage.setItem('senha',"");
                }
                $('#message').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif'/> </div>");
                $.ajax({
                    method: 'POST',
                    url: "php/login.php",
                    data: {
                        txtLogin: $('#usuario').val(),
                        txtSenha: $('#senha').val(),
                        btnLogarUsuario: 1
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            if (data.status == 401) {
                                $('#message').html(data.responseText + " <div class=\"alert alert-info\" role=\"alert\">Para receber um novo e-mail de confirmação, <a class=\"alert-link\" href='#' id=\"receberEmailVerificacao\">clique aqui</a></div>");
                                $('#receberEmailVerificacao').click(function (e) {
                                    $('#message').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif'/> </div>");
                                    $.ajax({
                                        method: 'POST',
                                        url: "php/autoCadastroVerificar.php",
                                        data: {
                                            txtLogin: $('#usuario').val(),
                                            btnNovaVerificacaoEmail: 1
                                        },
                                        dataType: "json",
                                        complete: function (data, status) {
                                            if (status === 'error' || !data.responseText) {
                                                console.log(data);
                                                $('#message').html(data.responseText);
                                            } else {
                                                $('#message').html(data.responseText);
                                            }
                                        }
                                    });
                                });
                            } else $('#message').html(data.responseText);
                        } else {
                            window.location = "http://<?=$GLOBALS['NOMESERVIDOR'];?>/admin.php";
                        }
                    }
                });
            });
            $('#registrarUsuario').click(function (e) {
                e.preventDefault();
                if ($('#termosDeUso').prop('checked')) {
                    $('#message').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif'/> </div>");
                    $.ajax({
                        method: 'POST',
                        url: "php/autoCadastro.php",
                        data: {
                            txtNome: $('#nomeCadastro').val(),
                            txtLogin: $('#usuarioCadastro').val(),
                            txtSenha: $('#senhaCadastro').val(),
                            btnCadastrarUsuario: 1
                        },
                        dataType: "json",
                        complete: function (data, status) {
                            if (status === 'error' || !data.responseText) {
                                console.log(data);
                                $('#message').html(data.responseText);
                            } else {
                                $('#message').html(data.responseText);
                            }
                            $('html, body').animate({
                                scrollTop: $("#message").offset().top
                            }, 500);
                        }
                    });
                } else {
                    $('#message').html("<div class=\"alert alert-danger text-center\" role=\"alert\">Verifique os termos de uso e a política de privacidade.</div>");
                    $('html, body').animate({
                        scrollTop: $("#message").offset().top
                    }, 500);
                }
            });
            $('#recuperarSenha').click(function (e) {
                e.preventDefault();
                $('#message').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif'/> </div>");
                $.ajax({
                    method: 'POST',
                    url: "php/trocaSenhaSolicitacao.php",
                    data: {
                        txtLogin: $('#emailRecuperar').val(),
                        btnRecuperarEmail: 1
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('#message').html(data.responseText);
                        } else {
                            $('#message').html(data.responseText);
                        }
                    }
                });

            });
            $('#trocarSenha').click(function (e) {
                e.preventDefault();
                $('#message').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif'/> </div>");
                $.ajax({
                    method: 'POST',
                    url: "php/trocaSenhaVerificar.php",
                    data: {
                        txtNovaSenha: $('#changeSenha').val(),
                        txtNovaSenhaConfirmacao: $('#changeSenhaConfirmacao').val(),
                        txtLogin: $('#changeEmail').val(),
                        uid: token,
                        btnAlterarSenha: 1
                    },
                    dataType: "json",
                    complete: function (data, status) {
                        if (status === 'error' || !data.responseText) {
                            console.log(data);
                            $('#message').html(data.responseText);
                        } else {
                            $('#message').html(data.responseText);
                        }
                    }
                });
            });
            $("input").keypress(function (e) {
                if (e.keyCode == 13) {
                    $('#enviarLoginUsuario').click();
                }
            });
        });
    </script>
</body>

</html>