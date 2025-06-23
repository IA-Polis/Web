<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 26/04/2018 14:09:20
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php"); ?>
<? if (isset($_SESSION['PERMISSOES']['listarUsuario'])) { ?>
	<div id="usuario1"></div>
    <div id="saida" class="saida"></div>
	<div id="usuario2">
		<script type="text/javascript">
			$().ready(function () {
				$('#btnAddUsuario').click(function () {
					$('#usuario1').html('');
					overlayStart();
					$.post("frm/cadastrarUsuario.php", {}, function (resultado) {
						$('#usuario1').html(resultado);
						overlayStop();
					});
				});
				$('.editarUsuario').click(function () {
					$('#usuario1').html('');
					overlayStart();
					$.post("frm/editarUsuario.php", {codUsuario: this.id}, function (resultado) {
						$('#usuario1').html(resultado);
						overlayStop();
					});
				});
				$('.excluirUsuario').click(function () {
					var codUsuario = this.id;
					$('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este usuário?');
					$('#modalExclusaoDelete').on('click', function(e) {
						$('#modalExclusaoButton').click();
						overlayStart();
						$.ajax({
							method: 'POST',
							url: "php/excluirUsuario.php",
							data: {
								codUsuario: codUsuario,
								btnExcluirUsuario: '1'
							},
							dataType: "json",
							complete: function (data, status) {
								if (status === 'error' || !data.responseText) {
									console.log(data);
									$('.saida').html(data.responseText);
									overlayStop();
								} else {
									$('.saida').html(data.responseText);
									$('#linhaUsuario' + codUsuario).addClass('hide');
									overlayStop();
								}
							}
						});
					});
					$('#modalExclusaoButton').click();
				});
				$('#dinamicUsuario').DataTable({
					stateSave: true,
					"aLengthMenu": [
						[10, 25, 50, 100, 200, -1],
						[10, 25, 50, 100, 200, "Todos"],
					],
					"language": {
						"emptyTable": "Lista vazia",
						"info": "Mostrando _START_ até _END_ de um total de _TOTAL_ registros",
						"infoEmpty": "Mostrando 0 até 0 de 0 registros",
						"infoFiltered": "(filtrado de um total de _MAX_ total records)",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": "Mostrar _MENU_ registros",
						"loadingRecords": "Carregando...",
						"processing": "Processando...",
						"search": "Busca:",
						"zeroRecords": "Nenhum registro encontrado",
						"paginate": {
							"first": "Primeiro",
							"last": "Último",
							"next": "Próximo",
							"previous": "Anterior"
						},
						"aria": {
							"sortAscending": ": ative para ordenar coluna de forma crescente",
							"sortDescending": ": ative para ordenar coluna de forma decrescente"
						}
					}
				});
			});
		</script>
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="card-body">
						<? if (isset($_SESSION['PERMISSOES']['cadastrarUsuario'])) { ?>
							<button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddUsuario" name="btnAddUsuario">++ Usuario</button><? } ?>
					</div>
				</div><!-- /# card -->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="box-title">Listagem de usuarios</h4>
					</div>
					<div class="card-body">
						<table id="dinamicUsuario" class="dynamic-table table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Nome</th>
								<th>Login</th>
								<th>Senha</th>
								<th>Troca Senha</th>
								<th>Ação</th>
							</tr>
							</thead>
							<tbody>
							<?
							$estaUsuario = new Classe\Usuario();
							$colUsuario = new Config\phpCollection();
							$colUsuario = $estaUsuario->carregarTodosCriterio('', '');
							if ($colUsuario->length > 0) {
								$aux = 1;
								do {
									?>
									<tr id='linhaUsuario<?= $colUsuario->current()->getCodUsuario(); ?>'>
										<td><?= $aux++; ?></td>
										<td><?= $colUsuario->current()->getNome(); ?></td>
										<td><?= $colUsuario->current()->getLogin(); ?></td>
										<td><?= $colUsuario->current()->getSenha(); ?></td>
										<td><?= $colUsuario->current()->getTrocaSenha(); ?></td>
										<td>
											<?
											if (isset($_SESSION['PERMISSOES']['editarUsuario'])) {
												?>
											<a style="cursor:pointer" title="Editar Usuario" class="editarUsuario green" id="<?= $colUsuario->current()->getCodUsuario(); ?>">
													<i class="fa fa-pencil fa-lg"></i>
												</a><?
											} ?>
											<?
											if (isset($_SESSION['PERMISSOES']['excluirUsuario'])) {
												?>
											<a style="cursor:pointer" title="Excluir Usuario" class="excluirUsuario red" id="<?= $colUsuario->current()->getCodUsuario(); ?>">
													<i class="fa fa-trash-o fa-lg"></i>
												</a><?
											} ?>
										</td>
									</tr>
									<?
								} while ($colUsuario->has_next());
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- /# column -->
		</div>
	</div>
<? } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>

