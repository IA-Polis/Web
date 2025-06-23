<?php require_once("config/config.php"); ?>

<!doctype html><!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]--><!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]--><!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]--><!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IAPolis</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png"/>
    <meta name="description" content="IAPolis">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assetsV3/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

    <!-- chosen -->
    <link rel="stylesheet" href="assetsV3/css/lib/chosen/chosen.min.css">
</head>

<body>

<!-- Scripts -->
<script src="assetsV3/js/jquery.min.js"></script>
<script src="assetsV3/js/jquery-3.6.0.min.js"></script>

<!-- moment -->
<script src="assetsV3/js/moment.min.js"></script>
<script src="assetsV3/js/moment-pt-br.js"></script>

<!-- chosen -->
<script src="assetsV3/js/lib/chosen/chosen.jquery.min.js"></script>

<script src="assetsV3/js/bootstrap.min.js"></script>

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper">
    <!--  Main wrapper -->
    <div class="body-wrapper">

        <!--Local Stuff-->
        <script>
            $(document).ready(function () {
                $("form").submit(function(e){
                    e.preventDefault();
                    return false;
                });

                $.post("frm/pictograma_avaliacaoExterna.php", {}, function (resultado) {
                    $('.block_gr').html(resultado);
                });
            });
        </script>
        <div class="loading"></div>
        <div class="container-fluid block_gr"></div>
    </div>
</div>
</div>
<div class="modal fade" id="modalExclusao" tabindex="-1" role="dialog" aria-labelledby="modalExclusaoLabel"
     aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Atenção!</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalExclusaoCancel" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modalExclusaoDelete" data-dismiss="modal">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
<button id="modalExclusaoButton" class="hide" data-toggle="modal" data-target="#modalExclusao">Static</button>
<div class="modal fade" id="modalPrescricao" tabindex="-1" role="dialog" aria-labelledby="modalPrescricaoLabel"
     aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Atenção!</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalPrescricaoCancel" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modalPrescricaoDelete" data-dismiss="modal">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
<button id=modalPrescricaoButton" class="hide" data-toggle="modal" data-target="#modalPrescricao">Static</button>

<div class="modal fade" id="modalAgradecimento" tabindex="-1" role="dialog" aria-labelledby="modalAgradecimentoLabel"
     aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Obrigado(a) por sua participação!</h5>
            </div>
            <div class="modal-body">
                <p>Você concluiu a avaliação das orientações geradas pela inteligência artificial para complementar as prescrições médicas na Atenção Primária à Saúde (APS). A sua contribuição é de extrema importância para o sucesso deste estudo.</p>

                <p><strong>O que acontece agora:</strong></p>
                <ul style="margin-left: 5%">
                    <li>As informações que você forneceu serão analisadas cuidadosamente.</li>
                    <li>Todos os dados serão armazenados de forma sigilosa e preservando a total anonimidade do avaliador.</li>
                    <li>Os resultados da pesquisa ajudarão a aprimorar as soluções de inteligência artificial no sistema de saúde.</li>
                </ul>

                <p><strong>Agradecemos muito pela sua colaboração!</strong></p>
                <p>Caso tenha mais alguma dúvida ou queira saber mais sobre os resultados da pesquisa, fique à vontade para nos contatar pelo e-mail <a href="mailto:iapolis@medicina.ufmg.br">iapolis@medicina.ufmg.br</a>.</p>

                <p>Atenciosamente,</p>
                <p>Equipe de Pesquisa – UFMG</p>
            </div>
        </div>
    </div>
</div>
<script>
    function overlayStart(message = "") {
        $('.loading').html("<div class=\"alert alert-light text-center\" role=\"alert\"><img height='25' src='<?=$GLOBALS['CAMINHOHTML']?>assets/images/load-32_256.gif'/> " + message + " </div>");
    }

    function overlayStop(dontGo = false) {
        window.setTimeout(function () {
            $('.loading').html("");
        }, 1e3);
    }

    function reforcoStandardSelect(){
        jQuery(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Não encontrado!",
            width: "100%"
        });
    }


    $(document).ready(function () {
        reforcoStandardSelect();
    });

    function randomNum(min, max) {
        return Math.random() * (max - min) + min;
    }

    window.addEventListener('load', function () {
        var status = document.getElementById("status");

        function updateOnlineStatus(event) {
            var condition = navigator.onLine ? "online" : "offline";

            if (condition == "offline") {
                overlayStart("Sistema Offline: verifique sua conexão!");
            } else {
                overlayStop();
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
    });
</script>

</body>

</html>