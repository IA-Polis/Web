<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 26/04/2018 14:09:20
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?><?php require_once("../config/config.php"); ?><? if (isset($_SESSION['PERMISSOES']['listarPapel'])) { ?>
	<div id="papel1"></div>
    <div id="saida" class="saida"></div>
	<div id="papel2">
		<script type="text/javascript">
			$().ready(function () {
				$('#btnAddPapel').click(function () {
					$('#papel1').html('');
					overlayStart();
					$.post("frm/cadastrarPapel.php", {}, function (resultado) {
						$('#papel1').html(resultado);
						overlayStop();
					});
				});
				$('.editarPapel').click(function () {
					$('#papel1').html('');
					overlayStart();
					$.post("frm/editarPapel.php", {codPapel: this.id}, function (resultado) {
						$('#papel1').html(resultado);
						overlayStop();
					});
				});
				$('.listarPapelFuncionalidade').click(function () {
					$('#papel1').html('');
					overlayStart();
					$.post("frm/listarPapelFuncionalidade.php", {codPapel: this.id}, function (resultado) {
						$('#papel1').html(resultado);
						overlayStop();
					});
				});
				$('.excluirPapel').click(function () {
					var codPapel = this.id;
					$('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este papel?');
					$('#modalExclusao').modal("show");
					$('#modalExclusaoDelete').on('click', function(e) {
						overlayStart();
						$.ajax({
							method: 'POST',
							url: "php/excluirPapel.php",
							data: {
								codPapel: codPapel,
								btnExcluirPapel: '1'
							},
							dataType: "json",
							complete: function (data, status) {
								if (status === 'error' || !data.responseText) {
									console.log(data);
									$('.saida').html(data.responseText);
									overlayStop();
								} else {
									$('.saida').html(data.responseText);
									$('#linhaPapel' + codPapel).addClass('hide');
									overlayStop();
								}
							}
						});
					});
				});
				$('#dinamicPapel').DataTable({
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
						<? if (isset($_SESSION['PERMISSOES']['cadastrarPapel'])) { ?>
							<button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddPapel" name="btnAddPapel">++ Papel</button><? } ?>
					</div>
				</div><!-- /# card -->
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="box-title">Listagem de papeis</h4>
					</div>
					<div class="card-body">
						<table id="dinamicPapel" class="dynamic-table table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Nome</th>
								<th>Descricao</th>
								<th>Ação</th>
							</tr>
							</thead>
							<tbody>
							<?
							$estaPapel = new Classe\Papel();
							$colPapel = new Config\phpCollection();
							$colPapel = $estaPapel->carregarTodosCriterio('', '');
							if ($colPapel->length > 0) {
								$aux = 1;
								do {
									?>
									<tr id='linhaPapel<?= $colPapel->current()->getCodPapel(); ?>'>
										<td><?= $aux++; ?></td>
										<td><?= $colPapel->current()->getNome(); ?></td>
										<td><?= $colPapel->current()->getDescricao(); ?></td>
										<td>
											<?
											if (isset($_SESSION['PERMISSOES']['editarPapel'])) {
												?>
											<a style="cursor:pointer" title="Editar Papel" class="editarPapel green" id="<?= $colPapel->current()->getCodPapel(); ?>">
													<i class="ti ti-pencil"></i>Editar Papel
												</a><br><?
											} ?>
											<?
											if (isset($_SESSION['PERMISSOES']['listarPapelFuncionalidade'])) {
												?>
											<a style="cursor:pointer" title="Listar Funcionalidades do Papel" class="listarPapelFuncionalidade blue" id="<?= $colPapel->current()->getCodPapel(); ?>">
													<i class="ti ti-list"></i>Listar Funcionalidades do Papel
												</a><br><?
											} ?>
											<?
											if (isset($_SESSION['PERMISSOES']['excluirPapel'])) {
												?>
											<a style="cursor:pointer" title="Excluir Papel" class="excluirPapel red" id="<?= $colPapel->current()->getCodPapel(); ?>">
													<i class="ti ti-git-pull-request-closed"></i>Excluir Papel
												</a><br><?
											} ?>
										</td>
									</tr>
									<?
								} while ($colPapel->has_next());
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