<div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Copyright &copy; 2024 LLM-Bill&Melinda</p>
</div>
</div>
</div>
</div>
<div class="modal fade" id="modalExclusao" tabindex="-1" role="dialog" aria-labelledby="modalExclusaoLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Atenção!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="modalExclusaoDelete" data-dismiss="modal">Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
<button id="modalExclusaoButton" class="hide" data-toggle="modal" data-target="#modalExclusao">Static</button>
<script>
    function overlayStart(message = "") {
        $('.loading').html("<div class=\"alert alert-light text-center\" style=\"padding-top: 20px !important;\" role=\"alert\"><img height='25' src='<?=$GLOBALS['CAMINHOHTML']?>assets/images/load-32_256.gif'/> " + message + " </div>");
    }

    function overlayStop(dontGo = false) {
        window.setTimeout(function () {
            $('.loading').html("");
        }, 1e3);
        /*if (!dontGo) {
            $('html, body').animate({
                scrollTop: $(".saida").offset().top
            }, 500);
        }*/
    }

    function reforcoStandardSelect() {
        jQuery(".standardSelect").select2({
            width: "100%",
            language: 'pt-BR'
        });
    }


    $(document).ready(function () {

        reforcoStandardSelect();

        $('#logoff').on('click', function () {
            overlayStart();
            $.post("php/logoff.php", function () {
                overlayStop(true);
                window.location = "http://<?=$GLOBALS['NOMESERVIDOR'];?>/index.php";
            });
        });
        $('#meuPerfil').on('click', function () {
            overlayStart();
            $.post("frm/editarUsuarioAuto.php", {}, function (resultado) {
                $('.block_gr').html(resultado);
                overlayStop();
            });
        });
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