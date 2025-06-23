<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['cadastrarPapel'])) { ?>
	<script type="text/javascript">
		$().ready(function () {
			$("form").click(function (e) {
				e.preventDefault();
				return false;
			});
            $('.saida').html("");
			$('#cadastrarPapel').click(function () {
				overlayStart();
				$.ajax({
					method: 'POST',
					url: "php/cadastrarPapel.php",
					data: {
						txtNome: $('#txtNome').val(),
						txtDescricao: $('#txtDescricao').val(),
						btnCadastrarPapel: '1'
					},
					dataType: "json",
					complete: function (data, status) {
						if (status === 'error' || !data.responseText) {
							console.log(data);
							$('.saida').html(data.responseText);
							overlayStop();
						}
						else {
							$('.saida').html(data.responseText);
							overlayStop();
							$('#papel1').html('');
						}
						$('#papel2').html('');
						$.post("frm/listarPapel.php", {}, function (resultado2) {
							$('#papel2').html(resultado2);
						});
					}
				});
			});
		});
	</script>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="box-title">Cadastrar papeis </h4>
				</div>
				<div class="card-body card-block">
					<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Nome</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtNome" name="txtNome" placeholder="Nome" class="form-control">
								<small class="form-text text-muted">Nome do papel</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Descrição</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtDescricao" name="txtDescricao" placeholder="Descrição" class="form-control">
								<small class="form-text text-muted">Descrição do papel</small>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarPapel" name="cadastrarPapel">Cadastrar</button>
							</div>
						</div>
					</form>
					<div class="card-body"></div>
				</div>
			</div><!-- /# column -->
		</div>
	</div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>

