<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php"); ?>
<?php if (isset($_SESSION['PERMISSOES']['cadastrarUsuario'])) { ?>
	<script type="text/javascript">
		$().ready(function () {
			$("form").click(function (e) {
				e.preventDefault();
				return false;
			});
            $('.saida').html("");
			$('#cadastrarUsuario').click(function () {
				overlayStart();
				$.ajax({
					method: 'POST',
					url: "php/cadastrarUsuario.php",
					data: {
						txtNome: $('#txtNome').val(),
						cboPapel: $('#cboPapel').val(),
						txtLogin: $('#txtLogin').val(),
						txtSenha: $('#txtSenhaEditarUsuario').val(),
						btnCadastrarUsuario: '1'
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
	</script>    <!--  Traffic  -->
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="box-title">Cadastrar usuário </h4>
				</div>
				<div class="card-body card-block">
					<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Nome</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtNome" name="txtNome" placeholder="Nome" class="form-control">
								<small class="form-text text-muted">Nome completo</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Login</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtLogin" name="txtLogin" placeholder="Login" class="form-control">
								<small class="form-text text-muted">Login de Acesso (email)</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Senha</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtSenhaEditarUsuario" name="txtSenhaEditarUsuario" placeholder="Senha" class="form-control">
								<small class="form-text text-muted">deixe vazio para criar senha automaticamente - envio por email</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="select" class=" form-control-label">Papel</label>
							</div>
							<div class="col-12 col-md-9">
								<?php
								$comboPapel = new Classe\Papel();
								echo $comboPapel->combo('', 'cboPapel', 1);
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary btn-block btn-sm" id="cadastrarUsuario" name="cadastrarUsuario">Cadastrar</button>
							</div>
						</div>
					</form>
					<div class="card-body"></div>
				</div>
			</div><!-- /# column -->
		</div>
	</div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
