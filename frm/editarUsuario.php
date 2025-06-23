<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['editarUsuario'])) { ?><?php
	if ($_POST['codUsuario']) {
		$carregarUsuario = new Classe\Usuario();
		$carregarUsuario->setCodUsuario($_POST['codUsuario']);
		$carregarUsuario->carregar();

		$_POST['txtNome'] = $carregarUsuario->getNome();
		$_POST['txtLogin'] = $carregarUsuario->getLogin();
		$_POST['txtSenhaEditarUsuario'] = $carregarUsuario->getSenha();

		$sistema = new Classe\PapelUsuario();
		$colPapelUsuario = $sistema->carregarTodosCriterio("codUsuario", $carregarUsuario->getCodUsuario());
		$_POST['cboPapel'] = [];

		if ($colPapelUsuario->length > 0) {
			do {
				$_POST['cboPapel'][] = $colPapelUsuario->current()->getCodPapel();
			} while ($colPapelUsuario->has_next());
		}
	}
	?>
	<script type="text/javascript">
		$().ready(function () {
			$("form").click(function (e) {
				e.preventDefault();
				return false;
			});
            $('.saida').html("");
			$('#editarUsuario').click(function () {
				overlayStart();
				$.ajax({
					method: 'POST',
					url: "php/editarUsuario.php",
					data: {
						codUsuario: $('#codUsuario').val(),
						txtNome: $('#txtNome').val(),
						cboPapel: $('#cboPapel').val(),
						txtLogin: $('#txtLogin').val(),
						txtSenha: $('#txtSenhaEditarUsuario').val(),
						btnEditarUsuario: '1'
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
							$('#usuario1').html('');
						}
						$('#usuario2').html('');
						$.post("frm/listarUsuario.php", {}, function (resultado2) {
							$('#usuario2').html(resultado2);
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
					<h4 class="box-title">Editar usuário </h4>
				</div>
				<div class="card-body card-block">
					<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
						<input name="codUsuario" type="hidden" id="codUsuario" value="<?= $_POST['codUsuario']; ?>">
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Nome</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtNome" name="txtNome" placeholder="Nome" class="form-control" value="<?= $_POST['txtNome']; ?>">
								<small class="form-text text-muted">Nome completo</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Login</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtLogin" name="txtLogin" placeholder="Login" class="form-control" value="<?= $_POST['txtLogin']; ?>">
								<small class="form-text text-muted">Login de Acesso (email)</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Senha</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtSenhaEditarUsuario" name="txtSenhaEditarUsuario" placeholder="Senha" class="form-control" value="<?= $_POST['txtSenhaEditarUsuario']; ?>">
								<small class="form-text text-muted">deixe como está para não trocar a senha do usuário</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="select" class=" form-control-label">Papel</label>
							</div>
							<div class="col-12 col-md-9">
								<?php
								$comboPapel = new Classe\Papel();
								echo $comboPapel->combo($_POST['cboPapel'], 'cboPapel', '1');
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary btn-block btn-sm" id="editarUsuario" name="editarUsuario">Editar</button>
							</div>
						</div>
					</form>
					<div class="card-body"></div>
				</div>
			</div><!-- /# column -->
		</div>
	</div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
