<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/configSemSessao.php"); ?>
<?php
if (!empty($_POST['token'])) {

    $participante = new \Classe\V3Participante();
    $participante->setToken($_POST['token']);
    $participante->carregarPeloToken();

    ?>
    <script type="text/javascript">
        $().ready(function () {
            $("form").submit(function (e) {
                e.preventDefault();
                return false;
            });
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Pesquisa Prescritores</h4>
                </div>
                <div class="card-body card-block">
                    <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-12">
                                <p><strong>Bem-vindo(a), <?= $participante->getNome(); ?>!</strong></p>
                                <p>É um prazer tê-lo(a) conosco! Você está prestes a iniciar a avaliação das orientações geradas pela inteligência artificial para complementar as prescrições médicas na Atenção Primária à Saúde (APS).</p>

                                <p><strong>Como funciona:</strong></p>
                                <ul style="margin-left: 5%">
                                    <li>Você receberá  casos clínicos da APS.</li>
                                    <li>Você elaborará prescrições com base nos casos clínicos recebidos</li>
                                    <li>A IA gerará orientações</li>
                                    <li>Você avaliará  as orientações geradas pela IA respondendo a perguntas curtas que guiarão sua avaliação.</li>
                                    <li>A atividade levará entre 20 a 25 minutos.</li>
                                </ul>

                                <p><strong>Importante:</strong></p>
                                <ul style="margin-left: 5%">
                                    <li>A sua participação é essencial para o sucesso do projeto.</li>
                                    <li>As informações coletadas são anônimas e serão tratadas com total sigilo.</li>
                                    <li>Se tiver qualquer dúvida, entre em contato com a nossa equipe pelo e-mail <a href="mailto:educaesusaps@medicina.ufmg.br">educaesusaps@medicina.ufmg.br</a>.</li>
                                </ul>

                                <p>Obrigado por sua contribuição! Sua experiência é fundamental para aprimorarmos o sistema de saúde.</p>

                                <p>Atenciosamente,</p>
                                <p>Equipe de Pesquisa – UFMG</p>

                                <p style="text-align: center">
                                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000;">
                                    <iframe
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                            src="https://www.youtube.com/embed/6Skk2ECjLtk?si=AZTQ99iOEVXpJWN6"
                                            title="YouTube video player"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin"
                                            allowfullscreen>
                                    </iframe>
                                </div>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-block proximaEtapa w-100" id="proximaEtapa"
                                        name="proximaEtapa">Iniciar Avaliação
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
